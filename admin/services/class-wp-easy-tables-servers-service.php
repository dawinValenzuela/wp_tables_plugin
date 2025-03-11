<?php
/**
 * WP Easy Tables Servers Service
 *
 * Handles the server-related operations for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WP_Easy_Tables_Servers_Service
 *
 * This class manages servers data and migrations in the WP Easy Tables plugin.
 */
class WP_Easy_Tables_Servers_Service {

	/**
	 * Database table name for servers.
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * Form name used in Elementor submissions.
	 *
	 * @var string
	 */
	private $form_name;

	/**
	 * Name of the retreat associated with the servers.
	 *
	 * @var string
	 */
	private $retreat_name;

	/**
	 * Constructor.
	 *
	 * Initializes the class with default table and form names.
	 */
	public function __construct() {
		$this->table_name   = 'easy_tables_servers';
		$this->form_name    = 'servers_form_xix_2025';
		$this->retreat_name = 'Retiro XIX 2025';
	}

	/**
	 * Retrieves all servers from the database.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array List of servers.
	 */
	public function get_servers() {
		global $wpdb;
		$table = $wpdb->prefix . 'easy_tables_servers';

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $table WHERE retreat_name = %s",
				$this->retreat_name
			)
		);
	}

	/**
	 * Retrieves form submissions from Elementor.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array List of servers extracted from Elementor submissions.
	 */
	public function get_submissions_values() {
		global $wpdb;
		$submissions_table        = $wpdb->prefix . 'e_submissions';
		$submissions_table_values = $wpdb->prefix . 'e_submissions_values';

		$submissions = $wpdb->get_results( "SELECT * FROM $submissions_table WHERE form_name = '$this->form_name'" );

		$servers = array();
		foreach ( $submissions as $submission ) {
			$server     = new stdClass();
			$server->id = $submission->id;
			$values     = $wpdb->get_results( "SELECT * FROM $submissions_table_values WHERE submission_id = $submission->id" );

			foreach ( $values as $value ) {
				$server->{$value->key} = $value->value;
			}

			$servers[] = $server;
		}

		return $servers;
	}

	/**
	 * Migrates server data from Elementor submissions to the new database table.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @return array Migration result status.
	 */
	public function migrate_servers_to_new_table() {
		global $wpdb;
		$servers_table     = $wpdb->prefix . 'easy_tables_servers';
		$submissions_table = $wpdb->prefix . 'e_submissions';

		try {
			$wpdb->query( 'START TRANSACTION' );

			$servers = $this->get_submissions_values();
			if ( empty( $servers ) ) {
				throw new Exception( 'No se encontraron servidores para migrar.' );
			}

			$updated  = 0;
			$inserted = 0;
			$deleted  = 0;

			foreach ( $servers as $server ) {
				$server_exists = $this->server_exists( $server->email, $servers_table );
				if ( $server_exists ) {
					$updated += $this->update_server( $server_exists, $server, $servers_table );
				} else {
					$inserted += $this->insert_server( $server, $servers_table );
				}
			}

			$deleted = $this->delete_obsolete_server( $submissions_table, $servers_table );

			$wpdb->query( 'COMMIT' );

			if ( $inserted === 0 && $updated === 0 && $deleted === 0 ) {
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
			error_log( 'Error en la migración de servidores: ' . $e->getMessage() );

			return array(
				'success' => false,
				'message' => 'Error durante la migración: ' . $e->getMessage(),
			);
		}
	}

	/**
	 * Checks if a server with the given email exists.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param string $email The email to check.
	 * @param string $table The table name.
	 * @return object|null The server object if found, otherwise null.
	 */
	private function server_exists( $email, $table ) {
		global $wpdb;
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE email = %s", $email ) );
	}

	/**
	 * Inserts a new server into the database.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param object $server Server data.
	 * @param string $table Table name.
	 * @return int 1 if inserted successfully.
	 */
	private function insert_server( $server, $table ) {
		global $wpdb;
		$server_data = $this->prepare_server_data( $server );
		$result      = $wpdb->insert( $table, $server_data );

		if ( $result === false ) {
			throw new Exception( 'Error al insertar el servidor con email ' . $server->email );
		}

		return 1;
	}

	/**
	 * Updates an existing server if data has changed.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param object $existing_server The existing server data.
	 * @param object $server The new server data.
	 * @param string $table The table name.
	 * @return int 1 if updated, 0 if no changes detected.
	 */
	private function update_server( $existing_server, $server, $table ) {
		global $wpdb;
		$server_data = $this->prepare_server_data( $server );
		$changes     = array_diff_assoc( (array) $server_data, (array) $existing_server );

		if ( ! empty( $changes ) ) {
			$result = $wpdb->update( $table, $server_data, array( 'email' => $server->email ) );
			if ( $result === false ) {
				throw new Exception( 'Error al actualizar el servidor con email ' . $server->email );
			}
			return 1;
		}

		return 0;
	}

	/**
	 * Retrieves a server by ID.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param int $server_id The server ID.
	 * @return object|null The server data if found.
	 */
	public function get_server( $server_id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'easy_tables_servers';
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE id = %d", $server_id ) );
	}

	/**
	 * Updates the additional information field of a server.
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 * @param int    $server_id Server ID.
	 * @param string $additional_info Additional information text.
	 * @return array Response message indicating success or failure.
	 */
	public function update_additional_info( $server_id, $additional_info ) {
		$server = $this->get_server( $server_id );

		if ( ! $server ) {
			return array(
				'success' => false,
				'message' => 'El servidor no existe.',
			);
		}

		global $wpdb;
		$servers_table = $wpdb->prefix . 'easy_tables_servers';
		$result        = $wpdb->update( $servers_table, array( 'additional_info' => $additional_info ), array( 'id' => $server_id ) );

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
