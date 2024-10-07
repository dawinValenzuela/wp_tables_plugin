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

    public function update_additional_info($request)
    {
        $walker_id = $request->get_param('walker_id');
        $additional_info = $request->get_param('additional_info');

        $result = $this->service->update_additional_info($walker_id, $additional_info);

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
