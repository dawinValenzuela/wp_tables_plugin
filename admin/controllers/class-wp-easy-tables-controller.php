<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../services/class-wp-easy-tables-service.php';

class WP_Easy_Tables_Controller {

    private $service;

    public function __construct() {
        $this->service = new WP_Easy_Tables_Service();
    }

    public function get_parish_congregations() {
        return $this->service->fetch_parish_congregations();
    }

    public function get_filtered_users($filters) {
        return $this->service->fetch_filtered_users($filters);
    }
    
}