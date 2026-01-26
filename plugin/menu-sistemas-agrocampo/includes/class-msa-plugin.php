<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Plugin
{
    public function run(): void
    {
        add_action('init', [$this, 'load_textdomain']);

        $settings = new MSA_Settings();
        $admin = new MSA_Admin($settings);
        $frontend = new MSA_Frontend($settings);

        add_action('init', [$frontend, 'register_rewrite_rule']);
        add_filter('query_vars', [$frontend, 'register_query_var']);
        add_action('template_redirect', [$frontend, 'render_standalone']);

        add_action('admin_menu', [$admin, 'register_menu']);
        add_action('admin_init', [$admin, 'register_settings']);
        add_action('admin_enqueue_scripts', [$admin, 'enqueue_assets']);
    }

    public function load_textdomain(): void
    {
        load_plugin_textdomain('menu-sistemas-agrocampo', false, dirname(plugin_basename(MSA_PLUGIN_FILE)) . '/languages');
    }
}
