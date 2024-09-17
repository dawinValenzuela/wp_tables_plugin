<?php

class WP_Easy_Tables_Admin
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->load_dependencies();
        $this->define_hooks();
    }

    private function load_dependencies()
    {
        require_once WP_EASY_TABLES_PATH . 'admin/controllers/class-wp-easy-tables-walkers-controller.php';
    }

    private function define_hooks()
    {
        $walkers_controller = new WP_Easy_Tables_Walkers_Controller();
        add_action('wp_ajax_migrate_walkers', array($walkers_controller, 'migrate_walkers'));
        add_action('wp_ajax_testing_action', array($walkers_controller, 'testing_action'));
    }

    public function add_plugin_admin_menu()
    {
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
            'Servers Table',
            'Tabla Servidores',
            'manage_options',
            $this->plugin_name . '_servers_table',
            array($this, 'display_servers_table_page')
        );

        add_submenu_page(
            $this->plugin_name,
            'Walkers Table',
            'Tabla Caminantes',
            'manage_options',
            $this->plugin_name . '_walkers_table',
            array($this, 'display_walkers_table_page')
        );
    }

    public function display_plugin_admin_page()
    {
        include_once 'partials/wp_easy_tables-admin-display.php';
    }

    public function display_walkers_table_page()
    {
        include_once 'partials/wp_easy_tables-admin-walkers-table-display.php';
    }

    public function display_servers_table_page()
    {
        include_once 'partials/wp_easy_tables-admin-servers-table-display.php';
    }

    public function register_settings()
    {
        // Registra configuraciones si es necesario.
    }

    function wp_easy_tables_enqueue_assets()
    {
        wp_enqueue_script(
            'wp-easy-tables-scripts',
            WP_EASY_TABLES_URL . 'build/bundle.js',
            ['wp-element', 'wp-components'],
            filemtime(WP_EASY_TABLES_PATH . 'build/bundle.js'),
            true
        );

        wp_enqueue_style('wp-components');

        // enqueue estilos para la tabla de walkers
        wp_enqueue_script(
            'wp-easy-tables-walkers-table',
            WP_EASY_TABLES_URL . 'admin/js/wp_easy_tables_admin_walkers.js',
            array('jquery'),
            $this->version,
            false
        );

        // javascrip de la tabla walkers
        // wp_enqueue_script(
        //     'wp-easy-tables-walkers-table',
        //     plugins_url('/assets/js/wp-easy-tables.js', __FILE__), // Ruta al script correcto
        //     array('jquery'), // Asegúrate de que jQuery esté cargado
        //     filemtime(plugin_dir_path(__FILE__) . '/assets/js/wp-easy-tables.js'),
        //     true
        // );


        // ajaxurl variable to use in the js file
        wp_localize_script(
            'wp-easy-tables-walkers-table',
            'wp_easy_tables_ajax',
            array('ajax_url' => admin_url('admin-ajax.php'))
        );
    }
}
