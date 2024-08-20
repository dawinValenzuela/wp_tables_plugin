<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../services/class-wp-easy-tables-walkers-service.php';

class WP_Easy_Tables_Walkers_Controller {

    private $service;

    public function __construct() {
        $this->service = new WP_Easy_Tables_Walkers_Service();
    }

    public function get_walkers() {
        return $this->service->get_walkers();
    }
}