<?php

if (!defined('ABSPATH')) {
    exit;
}

class WP_Easy_Tables_Servers_Service
{

    public function get_servers()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'easy_tables_servers';
        return $wpdb->get_results("SELECT * FROM $table");
    }

    public function get_submissions_values()
    {
        global $wpdb;
        $submissions_table = $wpdb->prefix . 'e_submissions';
        $submissions_table_values = $wpdb->prefix . 'e_submissions_values';

        // Get all submissions for the walkers_registration form and then get the information for each walker from the submissions_values table

        $submissions = $wpdb->get_results("SELECT * FROM $submissions_table WHERE form_name = 'servers_form'");

        $servers = array();
        foreach ($submissions as $submission) {
            $server = new stdClass();
            $server->id = $submission->id; // el submission_id es el id del servidor
            $values = $wpdb->get_results("SELECT * FROM $submissions_table_values WHERE submission_id = $submission->id");

            // iterare over the values and set the walker properties, e.g. inside values there is a row key and value.
            foreach ($values as $value) {
                $server->{$value->key} = $value->value;
            }

            $servers[] = $server;
        }

        return $servers;
    }

    public function migrate_servers_to_new_table()
    {
        global $wpdb;
        $servers_table = $wpdb->prefix . 'easy_tables_servers';
        $submissions_table = $wpdb->prefix . 'e_submissions';

        try {
            $wpdb->query('START TRANSACTION');

            // Obtener servidores desde Elementor
            $servers = $this->get_submissions_values();
            if (empty($servers)) {
                throw new Exception('No se encontraron servidores para migrar.');
            }

            $updated = 0;
            $inserted = 0;
            $deleted = 0;

            // Procesar cada servidor
            foreach ($servers as $server) {
                $server_exists = $this->server_exists($server->email, $servers_table);
                if ($server_exists) {
                    $updated += $this->update_server($server_exists, $server, $servers_table);
                } else {
                    $inserted += $this->insert_server($server, $servers_table);
                }
            }

            // Eliminar servidores que ya no existen en las tablas de Elementor
            $deleted = $this->delete_obsolete_server($submissions_table, $servers_table);

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
            error_log('Error en la migración de servidores: ' . $e->getMessage());

            return array(
                'success' => false,
                'message' => 'Error durante la migración: ' . $e->getMessage()
            );
        }
    }

    /**
     * Verifica si el servidor ya existe en la tabla por su email
     */
    private function server_exists($email, $table)
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE email = %s", $email));
    }

    /**
     * Inserta un nuevo servidor en la base de datos
     */
    private function insert_server($server, $table)
    {
        global $wpdb;
        $server_data = $this->prepare_server_data($server);
        $result = $wpdb->insert($table, $server_data);

        if ($result === false) {
            error_log('Insertado: ' . print_r($server_data, true));
            throw new Exception('Error al insertar el servidor con email ' . $server->email);
        }

        error_log('Insertado: ' . print_r($server_data, true));
        return 1; // Retorna 1 si se insertó correctamente
    }

    /**
     * Actualiza un servidor existente si ha cambiado la información
     */
    private function update_server($existing_server, $server, $table)
    {
        global $wpdb;
        $server_data = $this->prepare_server_data($server);
        $changes = array_diff_assoc((array) $server_data, (array) $existing_server);

        if (!empty($changes)) {
            $result = $wpdb->update($table, $server_data, array('email' => $server->email));
            if ($result === false) {
                throw new Exception('Error al actualizar el servidor con email ' . $server->email);
            }

            error_log('Actualizado: ' . print_r($server_data, true));
            return 1; // Retorna 1 si se actualizó correctamente
        }

        return 0; // Si no hubo cambios, no se actualiza
    }

    /**
     * Elimina servidores que ya no existen en las tablas de Elementor
     */
    private function delete_obsolete_server($submissions_table, $servers_table)
    {
        global $wpdb;
        $deleted = 0;
        $existing_servers = $wpdb->get_results("SELECT * FROM $servers_table");

        foreach ($existing_servers as $existing_server) {
            $submission = $wpdb->get_row($wpdb->prepare("SELECT * FROM $submissions_table WHERE form_name = 'servers_form' AND id = %d", $existing_server->submission_id));
            if (!$submission) {
                $result = $wpdb->delete($servers_table, array('id' => $existing_server->id));
                if ($result === false) {
                    throw new Exception('Error al eliminar el servidor con ID ' . $existing_server->id);
                }
                error_log('Eliminado ID: ' . $existing_server->id);
                $deleted++;
            }
        }

        return $deleted; // Número de registros eliminados
    }

    private function prepare_server_data($server)
    {
        return array(
            'submission_id' => $server->id,
            'retreat_name' => $server->retreat_name,
            'first_name' => $server->first_name,
            'last_name' => $server->last_name,
            'email' => $server->email,
            'phone_number' => $server->phone_number,
            'birthdate' => $server->birthdate,
            'eps' => $server->eps,
            'first_service_date' => $server->first_service_date,
            'church' => $server->church,
            'emergency_contact_name' => $server->emergency_contact_name,
            'emergency_contact_phone' => $server->emergency_contact_phone,
            'emergency_contact_relationship' => $server->emergency_contact_relationship,
            'medical_condition' => $server->medical_condition,
            'special_diet' => $server->special_diet,
        );
    }
}
