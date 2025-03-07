<?php
/**
 * WP Easy Tables Plugin
 *
 * This file contains the main class for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */

/**
 * WP Easy Tables Plugin
 *
 * @package WP_Easy_Tables
 */
class WP_Easy_Tables {

	/**
	 * The plugin name.
	 *
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Constructor for WP_Easy_Tables class.
	 *
	 * Initializes the plugin, sets the name and version,
	 * loads dependencies, and defines admin hooks.
	 */
	public function __construct() {
		$this->plugin_name = 'wp_easy_tables';
		$this->version     = '1.0';
		$this->load_dependencies();
		$this->define_admin_hooks();
	}

	/**
	 * Loads the required dependencies for the plugin.
	 *
	 * Includes the admin class that handles the plugin's backend functionality.
	 */
	private function load_dependencies() {
		require_once plugin_dir_path( __DIR__ ) . 'admin/class-wp-easy-tables-admin.php';
	}

	/**
	 * Defines admin-specific hooks for the plugin.
	 *
	 * Registers menu pages, settings, and scripts to be loaded in the admin panel.
	 */
	private function define_admin_hooks() {
		$plugin_admin = new WP_Easy_Tables_Admin( $this->get_plugin_name(), $this->get_version() );

		add_action( 'admin_menu', array( $plugin_admin, 'add_plugin_admin_menu' ) );
		add_action( 'admin_init', array( $plugin_admin, 'register_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $plugin_admin, 'wp_easy_tables_enqueue_assets' ) );
	}

	/**
	 * Runs the plugin.
	 *
	 * This method is reserved for future functionality.
	 */
	public function run() {
		// Code to execute when the plugin runs.
	}

	/**
	 * Gets the plugin name.
	 *
	 * @return string The plugin name.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Gets the plugin version.
	 *
	 * @return string The plugin version.
	 */
	public function get_version() {
		return $this->version;
	}
}
