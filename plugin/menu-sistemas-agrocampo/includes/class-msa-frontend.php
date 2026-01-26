<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Frontend
{
    private MSA_Settings $settings;

    public function __construct(MSA_Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register_rewrite_rule(): void
    {
        add_rewrite_rule('^menu-sistemas-agrocampo/?$', 'index.php?msa_menu=1', 'top');
    }

    public function register_query_var(array $vars): array
    {
        $vars[] = 'msa_menu';
        return $vars;
    }

    public function render_standalone(): void
    {
        if (get_query_var('msa_menu') !== '1') {
            return;
        }

        status_header(200);

        $settings = $this->settings->get_settings();
        $css_url = MSA_PLUGIN_URL . 'assets/css/menu-sistemas-agrocampo.css';

        require MSA_PLUGIN_DIR . 'templates/standalone.php';
        exit;
    }
}
