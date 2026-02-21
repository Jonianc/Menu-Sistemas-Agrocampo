<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Settings
{
    public const OPTION_KEY = 'msa_menu_settings';

    private function has_valid_items_nonce(): bool
    {
        if (!isset($_POST['msa_admin_nonce'])) {
            return false;
        }

        $nonce = sanitize_text_field(wp_unslash((string) $_POST['msa_admin_nonce']));
        return wp_verify_nonce($nonce, 'msa_admin_actions') !== false;
    }

    public function get_defaults(): array
    {
        return [
            'title' => 'Menú Sistemas Agrocampo',
            'subtitle' => 'Acceso rápido a los sistemas de gestión.',
            'logo_url' => '',
            'header_layout' => 'center',
            'quick_access_label' => '',
            'quick_access_url' => '',
            'link_target' => '_blank',
            'items' => [
                [
                    'title' => 'Cotizador Mantenciones',
                    'description' => 'Formulario de cotización para mantenciones.',
                    'badge' => '',
                    'hidden' => false,
                    'links' => [
                        [
                            'label' => 'Formulario',
                            'url' => 'https://sistemas.agrocampo.cl/test1/agrocampo-cotizador',
                        ],
                        [
                            'label' => 'Gestor de cotizaciones',
                            'url' => 'https://sistemas.agrocampo.cl/test1/agrocampo-cotizador/gestor',
                        ],
                    ],
                ],
                [
                    'title' => 'Creador QR OT',
                    'description' => 'Genera y gestiona códigos QR para OT.',
                    'badge' => '',
                    'hidden' => false,
                    'links' => [
                        [
                            'label' => 'Subir OT',
                            'url' => 'https://sistemas.agrocampo.cl/test1/otqr/upload/?k=6CS4CX4A4RMHS4634ML4',
                        ],
                        [
                            'label' => 'Gestionar QR',
                            'url' => 'https://sistemas.agrocampo.cl/test1/otqr/manage/?k=6CS4CX4A4RMHS4634ML4',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function get_settings(): array
    {
        $settings = get_option(self::OPTION_KEY, []);
        if (!is_array($settings)) {
            $settings = [];
        }

        return array_replace_recursive($this->get_defaults(), $settings);
    }

    public function sanitize(array $input): array
    {
        $settings = $this->get_defaults();

        $settings['title'] = isset($input['title']) ? sanitize_text_field($input['title']) : $settings['title'];
        $settings['subtitle'] = isset($input['subtitle']) ? sanitize_text_field($input['subtitle']) : $settings['subtitle'];
        $settings['logo_url'] = isset($input['logo_url']) ? esc_url_raw($input['logo_url']) : '';
        $settings['quick_access_label'] = isset($input['quick_access_label']) ? sanitize_text_field($input['quick_access_label']) : '';
        $settings['quick_access_url'] = isset($input['quick_access_url']) ? esc_url_raw($input['quick_access_url']) : '';

        if (isset($input['header_layout']) && in_array($input['header_layout'], ['center', 'logo-right', 'logo-left'], true)) {
            $settings['header_layout'] = $input['header_layout'];
        }

        if (isset($input['link_target']) && in_array($input['link_target'], ['_blank', '_self'], true)) {
            $settings['link_target'] = $input['link_target'];
        }

        $has_valid_items_nonce = $this->has_valid_items_nonce();

        if (isset($input['items']) && is_array($input['items']) && $has_valid_items_nonce) {
            $sanitized_items = [];
            foreach ($input['items'] as $item) {
                $sanitized_item = [
                    'title' => isset($item['title']) ? sanitize_text_field($item['title']) : '',
                    'description' => isset($item['description']) ? sanitize_text_field($item['description']) : '',
                    'badge' => isset($item['badge']) ? sanitize_text_field($item['badge']) : '',
                    'hidden' => !empty($item['hidden']),
                    'links' => [],
                ];

                if (isset($item['links']) && is_array($item['links'])) {
                    foreach ($item['links'] as $link) {
                        $label = isset($link['label']) ? sanitize_text_field($link['label']) : '';
                        $url = isset($link['url']) ? esc_url_raw($link['url']) : '';

                        if ($label === '' || $url === '') {
                            continue;
                        }

                        $sanitized_item['links'][] = [
                            'label' => $label,
                            'url' => $url,
                        ];
                    }
                }

                $sanitized_items[] = $sanitized_item;
            }

            $settings['items'] = $sanitized_items;
        }

        if (!$has_valid_items_nonce) {
            $existing_settings = $this->get_settings();
            $settings['items'] = $existing_settings['items'] ?? $settings['items'];
        }

        return $settings;
    }
}
