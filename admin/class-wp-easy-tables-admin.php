<?php
/**
 * WP Easy Tables Admin Class
 *
 * This file contains the WP_Easy_Tables_Admin class which handles the admin functionalities for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */

/**
 * WP_Easy_Tables_Admin Class
 *
 * This class handles the admin functionalities for the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */
class WP_Easy_Tables_Admin {



	/**
	 * The plugin name.
	 *
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	private $version;

	/**
	 * Constructor for WP_Easy_Tables_Admin class.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of the plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_dependencies();
		$this->define_hooks();
		$this->define_admin_apis();
	}

	/**
	 * Loads required dependencies.
	 */
	private function load_dependencies() {
		require_once WP_EASY_TABLES_PATH . 'admin/controllers/class-wp-easy-tables-walkers-controller.php';
		require_once WP_EASY_TABLES_PATH . 'admin/controllers/class-wp-easy-tables-servers-controller.php';
	}

	/**
	 * Defines WordPress hooks.
	 */
	private function define_hooks() {
		$walkers_controller = new WP_Easy_Tables_Walkers_Controller();
		$servers_controller = new WP_Easy_Tables_Servers_Controller();

		add_action( 'wp_ajax_migrate_walkers', array( $walkers_controller, 'migrate_walkers' ) );
		add_action( 'wp_ajax_migrate_servers', array( $servers_controller, 'migrate_servers' ) );
	}

	/**
	 * Registers the REST API endpoints for the admin functionalities.
	 */
	private function define_admin_apis() {
		add_action(
			'rest_api_init',
			function () {
				// Register endpoint to update additional info for walkers.
				register_rest_route(
					'wp-easy-tables/v1',
					'/update-walker-additional-info',
					array(
						'methods'             => 'POST',
						'callback'            => array( new WP_Easy_Tables_Walkers_Controller(), 'update_additional_info' ),
						'permission_callback' => function () {
							return true;
						},
					)
				);

				// Register endpoint to update additional info for servers.
				register_rest_route(
					'wp-easy-tables/v1',
					'/update-server-additional-info',
					array(
						'methods'             => 'POST',
						'callback'            => array( new WP_Easy_Tables_Servers_Controller(), 'update_additional_info' ),
						'permission_callback' => function () {
							return true;
						},
					)
				);

				// Register endpoint to export walkers to an Excel file.
				register_rest_route(
					'wp-easy-tables/v1',
					'/export-walkers',
					array(
						'methods'             => 'GET',
						'callback'            => array( new WP_Easy_Tables_Walkers_Controller(), 'export_walkers_to_excel' ),
						'permission_callback' => function () {
							return true;
						},
					)
				);

				// Register endpoint to export servers to an Excel file.
				register_rest_route(
					'wp-easy-tables/v1',
					'/export-servers',
					array(
						'methods'             => 'GET',
						'callback'            => array( new WP_Easy_Tables_Servers_Controller(), 'export_servers_to_excel' ),
						'permission_callback' => function () {
							return true;
						},
					)
				);
			}
		);
	}

	/**
	 * Adds the admin menu pages for the plugin.
	 */
	public function add_plugin_admin_menu() {
		add_menu_page(
			'WP Easy Tables',
			'WP Easy Tables',
			'manage_options',
			$this->plugin_name,
			'__return_null', // Dummy callback to ensure nothing is displayed.
			'dashicons-list-view',
			26
		);

		add_submenu_page(
			$this->plugin_name,
			'Servers Table',
			'Servers Table',
			'manage_options',
			$this->plugin_name . '_servers_table',
			array( $this, 'display_servers_table_page' )
		);

		add_submenu_page(
			$this->plugin_name,
			'Walkers Table',
			'Walkers Table',
			'manage_options',
			$this->plugin_name . '_walkers_table',
			array( $this, 'display_walkers_table_page' )
		);
	}

	/**
	 * Displays the main admin page for the plugin.
	 */
	public function display_plugin_admin_page() {
		include_once 'partials/wp_easy_tables-admin-display.php';
	}

	/**
	 * Displays the admin page for the walkers table.
	 */
	public function display_walkers_table_page() {
		include_once 'partials/wp_easy_tables-admin-walkers-table-display.php';
	}

	/**
	 * Displays the admin page for the servers table.
	 */
	public function display_servers_table_page() {
		include_once 'partials/wp-easy-tables-admin-servers-table-display.php';
	}

	/**
	 * Registers plugin settings.
	 */
	public function register_settings() {
		// Register settings if needed.
	}

	/**
	 * Enqueues admin scripts and styles for the plugin.
	 */
	public function wp_easy_tables_enqueue_assets() {
		wp_enqueue_script(
			'wp-easy-tables-scripts',
			WP_EASY_TABLES_URL . 'build/bundle.js',
			array( 'wp-element', 'wp-components' ),
			filemtime( WP_EASY_TABLES_PATH . 'build/bundle.js' ),
			true
		);

		wp_enqueue_style( 'wp-components' );

		// Enqueue JavaScript for the walkers table.
		wp_enqueue_script(
			'wp-easy-tables-walkers-table',
			WP_EASY_TABLES_URL . 'admin/js/wp_easy_tables_admin_walkers.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		// Enqueue JavaScript for the servers table.
		wp_enqueue_script(
			'wp-easy-tables-servers-table',
			WP_EASY_TABLES_URL . 'admin/js/wp_easy_tables_admin_servers.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		// Enqueue CSS for the admin tables.
		wp_enqueue_style(
			'wp-easy-tables-servers-table',
			WP_EASY_TABLES_URL . 'admin/css/wp_easy_tables_admin.css',
			array(),
			$this->version,
			'all'
		);

		// Localize script with the AJAX URL for walkers.
		wp_localize_script(
			'wp-easy-tables-walkers-table',
			'wp_easy_tables_ajax',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
		);

		// Localize script with the AJAX URL for servers.
		wp_localize_script(
			'wp-easy-tables-servers-table',
			'wp_easy_tables_servers_ajax',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
		);

		// Define a nonce for security.
		wp_localize_script(
			'wp-easy-tables-scripts',
			'wp_easy_tables_nonce',
			array( 'nonce' => wp_create_nonce( 'wp_easy_tables_nonce' ) )
		);
	}
}
