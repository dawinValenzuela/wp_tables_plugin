<?php

if (!defined('ABSPATH')) {
    exit;
}

class WP_Easy_Tables_Walkers_Service
{

    public function fetch_parish_congregations()
    {
        global $wpdb;
        return $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'user_registration_user_parish_congregation'");
    }

    public function fetch_filtered_users($filters)
    {
        $search_name = isset($filters['search_name']) ? sanitize_text_field($filters['search_name']) : '';
        $user_status = isset($filters['user_status']) ? sanitize_text_field($filters['user_status']) : '';
        $parish_congregation = isset($filters['parish_congregation']) ? sanitize_text_field($filters['parish_congregation']) : '';
        $users_per_page = isset($filters['users_per_page']) ? intval($filters['users_per_page']) : 10;
        $paged = isset($filters['paged']) ? intval($filters['paged']) : 1;
        $offset = ($paged - 1) * $users_per_page;

        $users_query_args = array(
            'search'         => '*' . esc_attr($search_name) . '*',
            'search_columns' => array('user_login', 'user_nicename', 'user_email'),
            'number'         => $users_per_page,
            'offset'         => $offset,
        );

        if ($user_status === 'active') {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_status',
                'value'   => 'active',
                'compare' => '='
            );
        } elseif ($user_status === 'inactive') {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_status',
                'value'   => 'inactive',
                'compare' => '='
            );
        }

        if (!empty($parish_congregation)) {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_registration_user_parish_congregation',
                'value'   => $parish_congregation,
                'compare' => '='
            );
        }

        $user_query = new WP_User_Query($users_query_args);
        $users = $user_query->get_results();

        return $users;
    }

    public function get_walkers()
    {
        global $wpdb;
        $walkers_table = $wpdb->prefix . 'easy_tables_walkers';
        return $wpdb->get_results("SELECT * FROM $walkers_table");
    }

    public function get_submissions_values()
    {
        global $wpdb;
        $submissions_table = $wpdb->prefix . 'e_submissions';
        $submissions_table_values = $wpdb->prefix . 'e_submissions_values';

        // Get all submissions for the walkers_registration form and then get the information for each walker from the submissions_values table

        $submissions = $wpdb->get_results("SELECT * FROM $submissions_table WHERE form_name = 'walkers_registration'");

        $walkers = array();
        foreach ($submissions as $submission) {
            $walker = new stdClass();
            $walker->id = $submission->id; // el submission_id es el id del caminante
            $values = $wpdb->get_results("SELECT * FROM $submissions_table_values WHERE submission_id = $submission->id");

            // iterare over the values and set the walker properties, e.g. inside values there is a row key and value.
            foreach ($values as $value) {
                $walker->{$value->key} = $value->value;
            }

            $walkers[] = $walker;
        }

        return $walkers;
    }

    public function migrate_walkers_to_new_table()
    {
        global $wpdb;
        $walkers_table = $wpdb->prefix . 'easy_tables_walkers';
        $submissions_table = $wpdb->prefix . 'e_submissions';

        try {
            $wpdb->query('START TRANSACTION');

            // Obtener caminantes desde Elementor
            $walkers = $this->get_submissions_values();
            if (empty($walkers)) {
                throw new Exception('No se encontraron caminantes para migrar.');
            }

            $updated = 0;
            $inserted = 0;
            $deleted = 0;

            // Procesar cada caminante
            foreach ($walkers as $walker) {
                $walker_exists = $this->walker_exists($walker->email, $walkers_table);
                if ($walker_exists) {
                    $updated += $this->update_walker($walker_exists, $walker, $walkers_table);
                } else {
                    $inserted += $this->insert_walker($walker, $walkers_table);
                }
            }

            // Eliminar caminantes que ya no existen en las tablas de Elementor
            $deleted = $this->delete_obsolete_walkers($submissions_table, $walkers_table);

            $wpdb->query('COMMIT');

            if ($inserted == 0 && $updated == 0 && $deleted == 0) {
                return array('success' => true, 'message' => 'No se detectaron cambios.');
            }

            return array(
                'success' => true,
                'message' => "Se han insertado $inserted registros, actualizado $updated registros y eliminado $deleted registros."
            );
        } catch (Exception $e) {
            $wpdb->query('ROLLBACK');
            error_log('Error en la migración de caminantes: ' . $e->getMessage());

            return array(
                'success' => false,
                'message' => 'Error durante la migración: ' . $e->getMessage()
            );
        }
    }

    /**
     * Verifica si el caminante ya existe en la tabla por su email
     */
    private function walker_exists($email, $table)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE email = %s", $email));
    }

    /**
     * Inserta un nuevo caminante en la base de datos
     */
    private function insert_walker($walker, $table)
    {
        global $wpdb;
        $walker_data = $this->prepare_walker_data($walker);
        $result = $wpdb->insert($table, $walker_data);

        if ($result === false) {
            throw new Exception('Error al insertar el caminante con email ' . $walker->email);
        }

        error_log('Insertado: ' . print_r($walker_data, true));
        return 1; // Retorna 1 si se insertó correctamente
    }

    /**
     * Actualiza un caminante existente si ha cambiado la información
     */
    private function update_walker($existing_walker, $walker, $table)
    {
        global $wpdb;
        $walker_data = $this->prepare_walker_data($walker);
        $changes = array_diff_assoc((array) $walker_data, (array) $existing_walker);

        if (!empty($changes)) {
            $result = $wpdb->update($table, $walker_data, array('email' => $walker->email));
            if ($result === false) {
                throw new Exception('Error al actualizar el caminante con email ' . $walker->email);
            }

            error_log('Actualizado: ' . print_r($walker_data, true));
            return 1; // Retorna 1 si se actualizó correctamente
        }

        return 0; // Si no hubo cambios, no se actualiza
    }

    /**
     * Elimina caminantes que ya no existen en las tablas de Elementor
     */
    private function delete_obsolete_walkers($submissions_table, $walkers_table)
    {
        global $wpdb;
        $deleted = 0;
        $existing_walkers = $wpdb->get_results("SELECT * FROM $walkers_table");

        foreach ($existing_walkers as $existing_walker) {
            $submission = $wpdb->get_row($wpdb->prepare("SELECT * FROM $submissions_table WHERE form_name = 'walkers_registration' AND id = %d", $existing_walker->submission_id));
            if (!$submission) {
                $result = $wpdb->delete($walkers_table, array('id' => $existing_walker->id));
                if ($result === false) {
                    throw new Exception('Error al eliminar el caminante con ID ' . $existing_walker->id);
                }
                error_log('Eliminado ID: ' . $existing_walker->id);
                $deleted++;
            }
        }

        return $deleted; // Número de registros eliminados
    }

    private function prepare_walker_data($walker)
    {
        return array(
            'submission_id' => $walker->id,
            'retreat_name' => $walker->retreat_name,
            'first_name' => $walker->first_name,
            'last_name' => $walker->last_name,
            'email' => $walker->email,
            'phone_number' => $walker->phone_number,
            'birthdate' => $walker->birthdate,
            'eps' => $walker->eps,
            'marital_status' => $walker->marital_status,
            'residence_address' => $walker->residence_address,
            'address_complement_one' => $walker->address_complement_one,
            'municipality' => $walker->municipality,
            'shirt_size' => $walker->shirt_size,
            'emergency_contact_name_1' => $walker->emergency_contact_name_1,
            'emergency_contact_phone_1' => $walker->emergency_contact_phone_1,
            'emergency_contact_relationship_1' => $walker->emergency_contact_relationship_1,
            'emergency_contact_name_2' => $walker->emergency_contact_name_2,
            'emergency_contact_phone_2' => $walker->emergency_contact_phone_2,
            'emergency_contact_relationship_2' => $walker->emergency_contact_relationship_2,
            'invited_by_name' => $walker->invited_by_name,
            'invited_by_phone' => $walker->invited_by_phone,
            'invited_contact_is_servant' => $walker->invited_contact_is_servant,
            'invited_by_relationship' => $walker->invited_by_relationship,
            'medical_condition' => $walker->medical_condition,
            'special_diet' => $walker->special_diet,
            'payment_by_name' => $walker->payment_by_name,
            'payment_by_phone' => $walker->payment_by_phone,
            'additional_notes' => $walker->additional_notes,
        );
    }
}
