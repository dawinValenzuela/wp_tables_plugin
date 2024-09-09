<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../services/class-wp-easy-tables-walkers-service.php';

class WP_Easy_Tables_Walkers_Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new WP_Easy_Tables_Walkers_Service();
        // ajax metod to migrate walkers
    }

    public function testing_action()
    {
        wp_send_json_success(array('message' => 'Testing action called.'));
    }

    public function get_walkers()
    {
        return $this->service->get_walkers();
    }

    public function migrate_walkers()
    {
        $result = $this->service->migrate_walkers_to_new_table();

        // Enviar la respuesta como JSON
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }

        // Finalizar la ejecución del script
        wp_die();
    }
}
