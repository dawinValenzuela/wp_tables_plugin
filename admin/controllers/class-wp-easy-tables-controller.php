<?php
/**
 * WP Easy Tables Controller
 *
 * This file contains the controller class for WP Easy Tables plugin.
 * It handles operations related to table management.
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . '../services/class-wp-easy-tables-service.php';

/**
 * Controller class for WP Easy Tables.
 * Handles operations related to table management.
 */
class WP_Easy_Tables_Controller {

	/**
	 * Service instance for handling table operations.
	 *
	 * @var WP_Easy_Tables_Service
	 */
	private $service;

	/**
	 * Constructor for WP_Easy_Tables_Controller.
	 * Initializes the service instance.
	 */
	public function __construct() {
		$this->service = new WP_Easy_Tables_Service();
	}

	/**
	 * Retrieves parish congregations.
	 *
	 * @return array List of parish congregations.
	 */
	public function get_parish_congregations() {
		return $this->service->fetch_parish_congregations();
	}

	/**
	 * Retrieves filtered users based on provided filters.
	 *
	 * @param array $filters Filters to apply for fetching users.
	 * @return array List of filtered users.
	 */
	public function get_filtered_users( $filters ) {
		return $this->service->fetch_filtered_users( $filters );
	}
}
