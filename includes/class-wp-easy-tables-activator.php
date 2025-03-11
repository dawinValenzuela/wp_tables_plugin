<?php
// phpcs:ignoreFile
/**
 * WP Easy Tables Activator
 *
 * This file contains the WP Easy Tables Activator class which handles the activation process for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */

/**
 * WP Easy Tables Activator
 *
 * This class handles the activation process for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */
class WP_Easy_Tables_Activator {

	/**
	 * Activates the WP Easy Tables plugin.
	 */
	public static function activate() {
		// Código para la activación del plugin.
		self::create_walkers_table();
		self::create_server_table();
		self::create_churches();
	}

	/**
	 * Creates the walkers table in the database.
	 */
	public static function create_walkers_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'easy_tables_walkers';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            submission_id mediumint(9) NOT NULL,
            retreat_name varchar(255) NOT NULL,
            first_name varchar(255) NOT NULL,
            last_name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone_number varchar(50) NOT NULL,
            birthdate date NOT NULL,
            eps varchar(255) NOT NULL,
            marital_status varchar(50) NOT NULL,
            residence_address text NOT NULL,
            address_complement_one text,
            municipality varchar(255) NOT NULL,
            shirt_size varchar(5) NOT NULL,
            emergency_contact_name_1 varchar(255) NOT NULL,
            emergency_contact_phone_1 varchar(50) NOT NULL,
            emergency_contact_relationship_1 varchar(100) NOT NULL,
            emergency_contact_name_2 varchar(255),
            emergency_contact_phone_2 varchar(50),
            emergency_contact_relationship_2 varchar(100),
            invited_by_name varchar(255),
            invited_by_phone varchar(50),
            invited_contact_is_servant tinyint(1),
            invited_by_relationship varchar(100),
            medical_condition text,
            special_diet text,
            payment_by_name varchar(255),
            payment_by_phone varchar(50),
            additional_notes text,
            additional_info text,  -- Campo para almacenar más información como JSON
            PRIMARY KEY  (id),
            UNIQUE KEY unique_submission_id (submission_id),
            UNIQUE KEY unique_email (email)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Creates the servers table in the database.
	 */
	public static function create_server_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'easy_tables_servers';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            submission_id mediumint(9) NOT NULL,
            retreat_name varchar(255) NOT NULL,
            first_name varchar(255) NOT NULL,
            last_name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            phone_number varchar(50) NOT NULL,
            birthdate date NOT NULL,
            eps varchar(255) NOT NULL,
            church varchar(255) NOT NULL,
            first_service_date date NOT NULL,
            emergency_contact_name varchar(255) NOT NULL,
            emergency_contact_phone varchar(50) NOT NULL,
            emergency_contact_relationship varchar(100) NOT NULL,
            medical_condition text,
            special_diet text,
            additional_info text,  -- Campo para almacenar más información como JSON
            PRIMARY KEY  (id),
            UNIQUE KEY unique_submission_id (submission_id),
            UNIQUE KEY unique_email (email)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Creates the churches table in the database and inserts initial data.
	 */
	public static function create_churches() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'easy_tables_churches';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            church_name varchar(255) NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY unique_church_name (church_name)
        ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		$churches = array(
			'Divino Niño',
			'Chiquinquira',
			'Cristo Misionero',
			'Divina Misericordia',
			'Espiritu Santo - Aguachica',
			'Maria Reina de las Misiones',
			'Nuestra Señora - Lagos',
			'Sagrado Corazón de Jesus',
			'San Rafael Arcangel - Piedecuesta',
		);

		foreach ( $churches as $church_name ) {
			$exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM $table_name WHERE church_name = %s", $church_name ) );
			if ( ! $exists ) {
				$wpdb->insert( $table_name, array( 'church_name' => $church_name ) );
			}
		}
	}
}
