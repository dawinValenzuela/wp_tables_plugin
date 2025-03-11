<?php
/**
 * WP Easy Tables Walkers Service.
 *
 * Provides functionalities to manage walkers data, including filtering, searching,
 * migration, and updates.
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class WP_Easy_Tables_Walkers_Service
 *
 * Handles walkers data operations for WP Easy Tables.
 */
class WP_Easy_Tables_Walkers_Service {

	/**
	 * Fetch distinct parish congregations from user meta.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array List of distinct parish congregations.
	 */
	public function fetch_parish_congregations() {
		global $wpdb;
		return $wpdb->get_col( "SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'user_registration_user_parish_congregation'" );
	}

	/**
	 * Fetch filtered users based on given filters.
	 *
	 * @param array $filters Associative array containing filters:
	 *                       - 'search_name' (string) The search term.
	 *                       - 'user_status' (string) The user status (active/inactive).
	 *                       - 'parish_congregation' (string) The congregation name.
	 *                       - 'users_per_page' (int) Number of users per page.
	 *                       - 'paged' (int) The page number.
	 * @return array List of filtered users.
	 */
	public function fetch_filtered_users( $filters ) {
		$search_name         = isset( $filters['search_name'] ) ? sanitize_text_field( $filters['search_name'] ) : '';
		$user_status         = isset( $filters['user_status'] ) ? sanitize_text_field( $filters['user_status'] ) : '';
		$parish_congregation = isset( $filters['parish_congregation'] ) ? sanitize_text_field( $filters['parish_congregation'] ) : '';
		$users_per_page      = isset( $filters['users_per_page'] ) ? intval( $filters['users_per_page'] ) : 10;
		$paged               = isset( $filters['paged'] ) ? intval( $filters['paged'] ) : 1;
		$offset              = ( $paged - 1 ) * $users_per_page;

		$users_query_args = array(
			'search'         => '*' . esc_attr( $search_name ) . '*',
			'search_columns' => array( 'user_login', 'user_nicename', 'user_email' ),
			'number'         => $users_per_page,
			'offset'         => $offset,
		);

		if ( 'active' === $user_status ) {
			$users_query_args['meta_query'][] = array(
				'key'     => 'user_status',
				'value'   => 'active',
				'compare' => '=',
			);
		} elseif ( 'inactive' === $user_status ) {
			$users_query_args['meta_query'][] = array(
				'key'     => 'user_status',
				'value'   => 'inactive',
				'compare' => '=',
			);
		}

		if ( ! empty( $parish_congregation ) ) {
			$users_query_args['meta_query'][] = array(
				'key'     => 'user_registration_user_parish_congregation',
				'value'   => $parish_congregation,
				'compare' => '=',
			);
		}

		$user_query = new WP_User_Query( $users_query_args );
		$users      = $user_query->get_results();

		return $users;
	}

	/**
	 * Retrieve all walkers from the database.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array List of walkers.
	 */
	public function get_walkers() {
		global $wpdb;
		$walkers_table = $wpdb->prefix . 'easy_tables_walkers';
		return $wpdb->get_results( "SELECT * FROM $walkers_table WHERE retreat_name = 'Retiro XIX 2025'" );
	}

	/**
	 * Search walkers by first name, last name, or email.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param string $search Search term to filter walkers.
	 * @return array List of matching walkers.
	 */
	public function search_walkers( $search ) {
		global $wpdb;
		$walkers_table = $wpdb->prefix . 'easy_tables_walkers';
		return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $walkers_table WHERE first_name LIKE %s OR last_name LIKE %s OR email LIKE %s", '%' . $search . '%', '%' . $search . '%', '%' . $search . '%' ) );
	}

	/**
	 * Retrieve submission values for walkers registration.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array List of walkers with their submission values.
	 */
	public function get_submissions_values() {
		global $wpdb;
		$submissions_table        = $wpdb->prefix . 'e_submissions';
		$submissions_table_values = $wpdb->prefix . 'e_submissions_values';

		$submissions = $wpdb->get_results( "SELECT * FROM $submissions_table WHERE form_name = 'walkers_registration'" );

		$walkers = array();
		foreach ( $submissions as $submission ) {
			$walker     = new stdClass();
			$walker->id = $submission->id;
			$values     = $wpdb->get_results( "SELECT * FROM $submissions_table_values WHERE submission_id = $submission->id" );

			foreach ( $values as $value ) {
				$walker->{$value->key} = $value->value;
			}

			$walkers[] = $walker;
		}

		return $walkers;
	}

	/**
	 * Migrate walkers data to a new table.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array Result of the migration process.
	 * @throws Exception If an error occurs during the migration process.
	 */
	public function migrate_walkers_to_new_table() {
		global $wpdb;
		$walkers_table     = $wpdb->prefix . 'easy_tables_walkers';
		$submissions_table = $wpdb->prefix . 'e_submissions';

		try {
			$wpdb->query( 'START TRANSACTION' );

			$walkers = $this->get_submissions_values();
			if ( empty( $walkers ) ) {
				throw new Exception( 'No se encontraron caminantes para migrar.' );
			}

			$updated  = 0;
			$inserted = 0;
			$deleted  = 0;

			foreach ( $walkers as $walker ) {
				$walker_exists = $this->walker_exists( $walker->email, $walkers_table );
				if ( $walker_exists ) {
					$updated += $this->update_walker( $walker_exists, $walker, $walkers_table );
				} else {
					$inserted += $this->insert_walker( $walker, $walkers_table );
				}
			}

			$deleted = $this->delete_obsolete_walkers( $submissions_table, $walkers_table );

			$wpdb->query( 'COMMIT' );

			if ( 0 === $inserted && 0 === $updated && 0 === $deleted ) {
				return array(
					'success' => true,
					'message' => 'No se detectaron cambios.',
				);
			}

			return array(
				'success' => true,
				'message' => "Se han insertado $inserted registros, actualizado $updated registros y eliminado $deleted registros.",
			);
		} catch ( Exception $e ) {
			$wpdb->query( 'ROLLBACK' );
			error_log( 'Error en la migración de caminantes: ' . $e->getMessage() );

			return array(
				'success' => false,
				'message' => 'Error durante la migración: ' . $e->getMessage(),
			);
		}
	}


	/**
	 * Check if a walker exists in the specified table by email.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param string $email The email of the walker.
	 * @param string $table The table name to check.
	 * @return object|null The walker data if found, otherwise null.
	 */
	private function walker_exists( $email, $table ) {
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE email = %s", $email ) );
	}

	/**
	 * Insert a new walker into the database.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param object $walker The walker data to insert.
	 * @param string $table The table name to insert the walker.
	 * @return int The number of rows affected (1 if inserted successfully).
	 * @throws Exception If an error occurs during the insert operation.
	 */
	private function insert_walker( $walker, $table ) {
		global $wpdb;
		$walker_data = $this->prepare_walker_data( $walker );
		$result      = $wpdb->insert( $table, $walker_data );

		if ( false === $result ) {
			throw new Exception( 'Error al insertar el caminante con email ' . $walker->email );
		}

		error_log( 'Insertado: ' . print_r( $walker_data, true ) );
		return 1; // Retorna 1 si se insertó correctamente
	}

	/**
	 * Update an existing walker in the database.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param object $existing_walker The existing walker data.
	 * @param object $walker The new walker data.
	 * @param string $table The table name to update the walker.
	 * @return int The number of rows affected (1 if updated successfully, 0 if no changes).
	 * @throws Exception If an error occurs during the update operation.
	 */
	private function update_walker( $existing_walker, $walker, $table ) {
		global $wpdb;
		$walker_data = $this->prepare_walker_data( $walker );
		$changes     = array_diff_assoc( (array) $walker_data, (array) $existing_walker );

		if ( ! empty( $changes ) ) {
			$result = $wpdb->update( $table, $walker_data, array( 'email' => $walker->email ) );
			if ( $result === false ) {
				throw new Exception( 'Error al actualizar el caminante con email ' . $walker->email );
			}

			error_log( 'Actualizado: ' . print_r( $walker_data, true ) );
			return 1; // Retorna 1 si se actualizó correctamente
		}

		return 0; // Si no hubo cambios, no se actualiza
	}

	/**
	 * Delete walkers that no longer exist in the submissions table.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param string $submissions_table The submissions table name.
	 * @param string $walkers_table The walkers table name.
	 * @return int The number of rows deleted.
	 * @throws Exception If an error occurs during the delete operation.
	 */
	private function delete_obsolete_walkers( $submissions_table, $walkers_table ) {
		global $wpdb;
		$deleted          = 0;
		$existing_walkers = $wpdb->get_results( "SELECT * FROM $walkers_table" );

		foreach ( $existing_walkers as $existing_walker ) {
			$submission = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $submissions_table WHERE form_name = 'walkers_registration' AND id = %d", $existing_walker->submission_id ) );
			if ( ! $submission ) {
				$result = $wpdb->delete( $walkers_table, array( 'id' => $existing_walker->id ) );
				if ( $result === false ) {
					throw new Exception( 'Error al eliminar el caminante con ID ' . $existing_walker->id );
				}
				error_log( 'Eliminado ID: ' . $existing_walker->id );
				++$deleted;
			}
		}

		return $deleted; // Número de registros eliminados
	}

	/**
	 * Prepare walker data for insertion or update.
	 *
	 * @param object $walker The walker data.
	 * @return array The walker data prepared for database operations.
	 */
	private function prepare_walker_data( $walker ) {
		return array(
			'submission_id'                    => $walker->id,
			'retreat_name'                     => $walker->retreat_name,
			'first_name'                       => $walker->first_name,
			'last_name'                        => $walker->last_name,
			'email'                            => $walker->email,
			'phone_number'                     => $walker->phone_number,
			'birthdate'                        => $walker->birthdate,
			'eps'                              => $walker->eps,
			'marital_status'                   => $walker->marital_status,
			'residence_address'                => $walker->residence_address,
			'address_complement_one'           => $walker->address_complement_one,
			'municipality'                     => $walker->municipality,
			'shirt_size'                       => $walker->shirt_size,
			'emergency_contact_name_1'         => $walker->emergency_contact_name_1,
			'emergency_contact_phone_1'        => $walker->emergency_contact_phone_1,
			'emergency_contact_relationship_1' => $walker->emergency_contact_relationship_1,
			'emergency_contact_name_2'         => $walker->emergency_contact_name_2,
			'emergency_contact_phone_2'        => $walker->emergency_contact_phone_2,
			'emergency_contact_relationship_2' => $walker->emergency_contact_relationship_2,
			'invited_by_name'                  => $walker->invited_by_name,
			'invited_by_phone'                 => $walker->invited_by_phone,
			'invited_contact_is_servant'       => $walker->invited_contact_is_servant,
			'invited_by_relationship'          => $walker->invited_by_relationship,
			'medical_condition'                => $walker->medical_condition,
			'special_diet'                     => $walker->special_diet,
			'payment_by_name'                  => $walker->payment_by_name,
			'payment_by_phone'                 => $walker->payment_by_phone,
			'additional_notes'                 => $walker->additional_notes,
		);
	}

	/**
	 * Retrieve a walker by ID.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param int $walker_id The ID of the walker.
	 * @return object|null The walker data if found, otherwise null.
	 */
	public function get_walker( $walker_id ) {
		global $wpdb;
		$walkers_table = $wpdb->prefix . 'easy_tables_walkers';
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $walkers_table WHERE id = %d", $walker_id ) );
	}

	/**
	 * Update additional information for a walker.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param int    $walker_id       The ID of the walker to update.
	 * @param string $additional_info The additional information to update.
	 * @return array Response message indicating success or failure.
	 */
	public function update_additional_info( $walker_id, $additional_info ) {
		$walker = $this->get_walker( $walker_id );

		if ( ! $walker ) {
			return array(
				'success' => false,
				'message' => 'El caminante no existe.',
			);
		}

		global $wpdb;
		$walkers_table = $wpdb->prefix . 'easy_tables_walkers';
		$result        = $wpdb->update( $walkers_table, array( 'additional_info' => $additional_info ), array( 'id' => $walker_id ) );

		if ( $result === false ) {
			return array(
				'success' => false,
				'message' => 'Error al actualizar la información adicional.',
			);
		}

		return array(
			'success' => true,
			'message' => 'Información adicional actualizada correctamente.',
		);
	}
}
