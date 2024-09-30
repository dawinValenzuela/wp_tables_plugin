<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../services/class-wp-easy-tables-servers-service.php';

class WP_Easy_Tables_Servers_Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new WP_Easy_Tables_Servers_Service();
    }

    public function get_servers()
    {
        return $this->service->get_servers();
    }

    public function migrate_servers()
    {
        $result = $this->service->migrate_servers_to_new_table();

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
