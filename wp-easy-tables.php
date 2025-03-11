<?php
/**
 * Plugin Name: WP Easy Tables
 * Description: Muestra los usuarios y su información de usermeta en una tabla.
 * Version: 1.0
 * Author: Tu Nombre
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

define( 'WP_EASY_TABLES_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_EASY_TABLES_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Activates the WP Easy Tables plugin.
 */
function activate_wp_easy_tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-easy-tables-activator.php';
	WP_Easy_Tables_Activator::activate();
}

/**
 * Deactivates the WP Easy Tables plugin.
 */
function deactivate_wp_easy_tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-easy-tables-deactivator.php';
	WP_Easy_Tables_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_easy_tables' );
register_deactivation_hook( __FILE__, 'deactivate_wp_easy_tables' );

require plugin_dir_path( __FILE__ ) . 'includes/class-wp-easy-tables.php';

/**
 * Runs the WP Easy Tables plugin.
 */
function run_wp_easy_tables() {
	$plugin = new WP_Easy_Tables();
}
run_wp_easy_tables();
