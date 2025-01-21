<?php

class WP_Easy_Tables
{
    protected $plugin_name;
    protected $version;

    public function __construct()
    {
        $this->plugin_name = 'wp_easy_tables';
        $this->version = '1.0';
        $this->load_dependencies();
        $this->define_admin_hooks();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp_easy_tables-admin.php';
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new WP_Easy_Tables_Admin($this->get_plugin_name(), $this->get_version());
        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'));
        add_action('admin_init', array($plugin_admin, 'register_settings'));
        add_action('admin_enqueue_scripts', array($plugin_admin, 'wp_easy_tables_enqueue_assets'));
    }

    public function run()
    {
        // Código para correr el plugin.
    }

    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    public function get_version()
    {
        return $this->version;
    }
}
