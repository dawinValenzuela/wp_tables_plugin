<?php

class WP_Easy_Tables_Admin {
    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'WP Easy Tables',
            'WP Easy Tables',
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_plugin_admin_page' ),
            'dashicons-list-view',
            26
        );
    }

    public function display_plugin_admin_page() {
        include_once 'partials/wp_easy_tables-admin-display.php';
    }

    public function register_settings() {
        // Registra configuraciones si es necesario.
    }
}
?>
