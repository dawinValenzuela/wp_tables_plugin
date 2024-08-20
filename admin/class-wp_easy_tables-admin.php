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
            // array( $this, 'display_plugin_admin_page' ), 
            '__return_null', // Dummy callback to ensure nothing is displayed
            'dashicons-list-view',
            26
        );

        add_submenu_page(
            $this->plugin_name,
            'Registered Users',
            'Registered Users',
            'manage_options',
            $this->plugin_name . '_registered_users',
            array( $this, 'display_registered_users_page' )
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

    public function display_plugin_admin_page() {
        include_once 'partials/wp_easy_tables-admin-display.php';
    }

    public function display_walkers_table_page() {
        include_once 'partials/wp_easy_tables-admin-walkers-table-display.php';
    }

    public function register_settings() {
        // Registra configuraciones si es necesario.
    }
}
?>
