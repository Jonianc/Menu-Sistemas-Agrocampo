<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Admin
{
    private MSA_Settings $settings;

    public function __construct(MSA_Settings $settings)
    {
        $this->settings = $settings;
    }

    public function register_menu(): void
    {
        add_menu_page(
            __('Menú Sistemas Agrocampo', 'menu-sistemas-agrocampo'),
            __('Menú Sistemas', 'menu-sistemas-agrocampo'),
            'manage_options',
            'msa-menu-settings',
            [$this, 'render_settings_page'],
            'dashicons-screenoptions',
            60
        );

        add_submenu_page(
            'msa-menu-settings',
            __('Ajustes', 'menu-sistemas-agrocampo'),
            __('Ajustes', 'menu-sistemas-agrocampo'),
            'manage_options',
            'msa-menu-settings',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings(): void
    {
        register_setting(
            'msa_menu_settings_group',
            MSA_Settings::OPTION_KEY,
            [
                'sanitize_callback' => [$this->settings, 'sanitize'],
                'default' => $this->settings->get_defaults(),
            ]
        );
    }

    public function enqueue_assets(string $hook): void
    {
        if (!in_array($hook, ['toplevel_page_msa-menu-settings', 'menu-sistemas_page_msa-menu-settings'], true)) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style(
            'msa-admin',
            MSA_PLUGIN_URL . 'assets/css/menu-sistemas-agrocampo-admin.css',
            [],
            MSA_PLUGIN_VERSION
        );

        wp_enqueue_script(
            'msa-admin',
            MSA_PLUGIN_URL . 'assets/js/menu-sistemas-agrocampo-admin.js',
            ['jquery', 'jquery-ui-sortable'],
            MSA_PLUGIN_VERSION,
            true
        );

        wp_localize_script(
            'msa-admin',
            'menuSistemasAgrocampo',
            [
                'optionKey' => MSA_Settings::OPTION_KEY,
                'adminNonce' => wp_create_nonce('msa_admin_actions'),
                'labels' => [
                    'access' => __('Acceso', 'menu-sistemas-agrocampo'),
                    'remove' => __('Quitar', 'menu-sistemas-agrocampo'),
                    'buttonName' => __('Nombre del botón', 'menu-sistemas-agrocampo'),
                    'selectLogo' => __('Selecciona un logo', 'menu-sistemas-agrocampo'),
                    'useLogo' => __('Usar este logo', 'menu-sistemas-agrocampo'),
                    'removeSystemConfirm' => __('¿Seguro que deseas eliminar este sistema?', 'menu-sistemas-agrocampo'),
                    'dragSystem' => __('Arrastrar sistema', 'menu-sistemas-agrocampo'),
                    'nonceError' => __('No se pudo validar la sesión de edición. Recarga la página para continuar.', 'menu-sistemas-agrocampo'),
                    'previewNoItems' => __('No hay sistemas visibles en la vista previa.', 'menu-sistemas-agrocampo'),
                    'previewUntitled' => __('Sistema sin nombre', 'menu-sistemas-agrocampo'),
                    'previewNoDescription' => __('Sin descripción.', 'menu-sistemas-agrocampo'),
                ],
            ]
        );
    }

    public function render_settings_page(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = $this->settings->get_settings();
        $option_key = MSA_Settings::OPTION_KEY;
        $menu_url = home_url('/menu-sistemas-agrocampo/');
        require MSA_PLUGIN_DIR . 'templates/admin-settings.php';
    }
}
