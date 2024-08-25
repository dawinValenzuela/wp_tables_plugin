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

    function wp_easy_tables_enqueue_assets() {
        wp_enqueue_script(
            'wp-easy-tables-scripts',
            WP_EASY_TABLES_URL . 'build/bundle.js',
            ['wp-element', 'wp-components'],
            filemtime(WP_EASY_TABLES_PATH . 'build/bundle.js'),
            true
        );

        wp_enqueue_style('wp-components');
        // Encolar los estilos de los componentes de WordPress
        // wp_enqueue_style(
        //     'wp-components', // Identificador del estilo de los componentes de WordPress
        //     plugins_url('/build/style.css', __FILE__),
        //     array('wp-edit-blocks'), // Dependencia de Gutenberg
        //     filemtime(plugin_dir_path(__FILE__) . '/build/style.css')
        // );
    }
}
?>
