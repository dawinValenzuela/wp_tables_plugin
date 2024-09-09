<?php

/**
 * fields: retreat_name, first_name, last_name, email, phone_number, birthdate, eps, marital_status, residence_address, address_complement_one, municipality, shirt_size, emergency_contact_name_1, emergency_contact_phone_1, emergency_contact_relationship_1, emergency_contact_name_2
 * emergency_contact_phone_2, emergency_contact_relationship_2, invited_by_name, invited_by_phone, invited_contact_is_servant, invited_by_relationship, medical_condition, special_diet, payment_by_name, payment_by_phone, additional_notes
 */

class WP_Easy_Tables_Activator
{
    public static function activate()
    {
        // Código para la activación del plugin.
        self::create_walkers_table();
    }

    // function to create a new table for walkers, this should be call it when activate the plugin
    public static function create_walkers_table()
    {
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

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
