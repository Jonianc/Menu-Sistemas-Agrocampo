<?php
/**
 * Plugin Name: Menú Sistemas Agrocampo
 * Description: Menú standalone en frontend para gestionar sistemas de Agrocampo.
 * Version: 1.0.0
 * Author: Agrocampo
 * License: GPL-2.0-or-later
 * Text Domain: menu-sistemas-agrocampo
 */

if (!defined('ABSPATH')) {
    exit;
}

const MENU_SISTEMAS_AGROCAMPO_VERSION = '1.0.0';
const MENU_SISTEMAS_AGROCAMPO_OPTION = 'msa_menu_settings';

/**
 * Registers the frontend stylesheet for the menu.
 */
function msa_register_assets(): void
{
    $style_handle = 'menu-sistemas-agrocampo-style';
    $style_url = plugins_url('assets/menu-sistemas-agrocampo.css', __FILE__);

    wp_register_style($style_handle, $style_url, [], MENU_SISTEMAS_AGROCAMPO_VERSION);
}
add_action('wp_enqueue_scripts', 'msa_register_assets');

/**
 * Get menu settings with defaults.
 */
function msa_get_settings(): array
{
    $defaults = [
        'title' => 'Menú Sistemas Agrocampo',
        'subtitle' => 'Acceso rápido a los sistemas de gestión.',
        'logo_url' => '',
        'header_layout' => 'center',
        'items' => [
            [
                'title' => 'Cotizador Mantenciones',
                'description' => 'Formulario de cotización para mantenciones.',
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

    $settings = get_option(MENU_SISTEMAS_AGROCAMPO_OPTION, []);
    if (!is_array($settings)) {
        $settings = [];
    }

    return array_replace_recursive($defaults, $settings);
}

/**
 * Render the menu markup.
 */
function msa_render_menu(): string
{
    wp_enqueue_style('menu-sistemas-agrocampo-style');

    $settings = msa_get_settings();

    ob_start();
    ?>
    <section class="msa-menu" aria-label="Menú Sistemas Agrocampo">
        <header class="msa-menu__header <?php echo esc_attr('msa-menu__header--' . $settings['header_layout']); ?>">
            <?php if (!empty($settings['logo_url'])) : ?>
                <img class="msa-menu__logo" src="<?php echo esc_url($settings['logo_url']); ?>" alt="Logo Agrocampo">
            <?php endif; ?>
            <div class="msa-menu__text">
                <h2 class="msa-menu__title"><?php echo esc_html($settings['title']); ?></h2>
                <p class="msa-menu__subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
            </div>
        </header>
        <div class="msa-menu__grid">
            <?php foreach ($settings['items'] as $item) : ?>
                <article class="msa-menu__card">
                    <h3 class="msa-menu__card-title"><?php echo esc_html($item['title']); ?></h3>
                    <p class="msa-menu__card-description"><?php echo esc_html($item['description']); ?></p>
                    <div class="msa-menu__actions">
                        <?php foreach ($item['links'] as $link) : ?>
                            <a
                                class="msa-menu__link"
                                href="<?php echo esc_url($link['url']); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <?php echo esc_html($link['label']); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    return (string) ob_get_clean();
}

/**
 * Register rewrite rule for the standalone menu page.
 */
function msa_register_rewrite_rule(): void
{
    add_rewrite_rule('^menu-sistemas-agrocampo/?$', 'index.php?msa_menu=1', 'top');
}
add_action('init', 'msa_register_rewrite_rule');

/**
 * Register the query var used for the standalone menu page.
 *
 * @param array $vars
 * @return array
 */
function msa_register_query_var(array $vars): array
{
    $vars[] = 'msa_menu';
    return $vars;
}
add_filter('query_vars', 'msa_register_query_var');

/**
 * Render the standalone menu page without theme dependencies.
 */
function msa_render_standalone_page(): void
{
    if (get_query_var('msa_menu') !== '1') {
        return;
    }

    status_header(200);
    $css_url = plugins_url('assets/menu-sistemas-agrocampo.css', __FILE__);

    echo '<!doctype html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>Menú Sistemas Agrocampo</title>';
    echo '<link rel="stylesheet" href="' . esc_url($css_url) . '">';
    echo '</head>';
    echo '<body>';
    echo msa_render_menu();
    echo '</body>';
    echo '</html>';
    exit;
}
add_action('template_redirect', 'msa_render_standalone_page');

/**
 * Register admin settings page.
 */
function msa_register_admin_menu(): void
{
    add_menu_page(
        'Menú Sistemas Agrocampo',
        'Menú Sistemas',
        'manage_options',
        'msa-menu-settings',
        'msa_render_settings_page',
        'dashicons-screenoptions',
        60
    );
}
add_action('admin_menu', 'msa_register_admin_menu');

/**
 * Register settings for the menu.
 */
function msa_register_settings(): void
{
    register_setting(
        'msa_menu_settings_group',
        MENU_SISTEMAS_AGROCAMPO_OPTION,
        [
            'sanitize_callback' => 'msa_sanitize_settings',
            'default' => msa_get_settings(),
        ]
    );
}
add_action('admin_init', 'msa_register_settings');

/**
 * Sanitize settings fields.
 *
 * @param array $input
 * @return array
 */
function msa_sanitize_settings(array $input): array
{
    $settings = msa_get_settings();

    $settings['title'] = isset($input['title']) ? sanitize_text_field($input['title']) : $settings['title'];
    $settings['subtitle'] = isset($input['subtitle']) ? sanitize_text_field($input['subtitle']) : $settings['subtitle'];
    $settings['logo_url'] = isset($input['logo_url']) ? esc_url_raw($input['logo_url']) : '';
    if (isset($input['header_layout']) && in_array($input['header_layout'], ['center', 'logo-right', 'logo-left'], true)) {
        $settings['header_layout'] = $input['header_layout'];
    }

    if (isset($input['items']) && is_array($input['items'])) {
        $sanitized_items = [];
        foreach ($input['items'] as $item) {
            $sanitized_item = [
                'title' => isset($item['title']) ? sanitize_text_field($item['title']) : '',
                'description' => isset($item['description']) ? sanitize_text_field($item['description']) : '',
                'links' => [],
            ];

            if (isset($item['links']) && is_array($item['links'])) {
                foreach ($item['links'] as $link) {
                    $sanitized_item['links'][] = [
                        'label' => isset($link['label']) ? sanitize_text_field($link['label']) : '',
                        'url' => isset($link['url']) ? esc_url_raw($link['url']) : '',
                    ];
                }
            }

            $sanitized_items[] = $sanitized_item;
        }
        $settings['items'] = $sanitized_items;
    }

    return $settings;
}

/**
 * Enqueue admin assets for settings page.
 */
function msa_enqueue_admin_assets(string $hook): void
{
    if ($hook !== 'toplevel_page_msa-menu-settings') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'msa-admin',
        plugins_url('assets/menu-sistemas-agrocampo-admin.js', __FILE__),
        ['jquery'],
        MENU_SISTEMAS_AGROCAMPO_VERSION,
        true
    );
    wp_localize_script(
        'msa-admin',
        'menuSistemasAgrocampo',
        [
            'option' => MENU_SISTEMAS_AGROCAMPO_OPTION,
        ]
    );
}
add_action('admin_enqueue_scripts', 'msa_enqueue_admin_assets');

/**
 * Render the settings page.
 */
function msa_render_settings_page(): void
{
    $settings = msa_get_settings();
    ?>
    <div class="wrap">
        <h1>Menú Sistemas Agrocampo</h1>
        <style>
            .msa-logo-preview {
                max-width: 180px;
                height: auto;
                display: block;
                margin-top: 0.5rem;
            }
            .msa-item-block {
                border: 1px solid #dcdcdc;
                padding: 1rem;
                margin-bottom: 1rem;
                background: #ffffff;
            }
            .msa-actions {
                margin-top: 1rem;
            }
            .msa-link-row {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                align-items: center;
            }
            .msa-link-row input {
                flex: 1 1 220px;
            }
            .msa-link-row .button {
                flex: 0 0 auto;
            }
        </style>
        <form method="post" action="options.php">
            <?php settings_fields('msa_menu_settings_group'); ?>
            <h2 class="title">Header</h2>
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label for="msa-title">Título</label></th>
                        <td>
                            <input
                                type="text"
                                id="msa-title"
                                class="regular-text"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[title]"
                                value="<?php echo esc_attr($settings['title']); ?>"
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="msa-subtitle">Subtítulo</label></th>
                        <td>
                            <input
                                type="text"
                                id="msa-subtitle"
                                class="regular-text"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[subtitle]"
                                value="<?php echo esc_attr($settings['subtitle']); ?>"
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="msa-logo-url">Logo</label></th>
                        <td>
                            <input
                                type="text"
                                id="msa-logo-url"
                                class="regular-text"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[logo_url]"
                                value="<?php echo esc_url($settings['logo_url']); ?>"
                            >
                            <button type="button" class="button msa-upload-logo">Subir logo</button>
                            <p class="description">Sube o selecciona el logo para mostrar en el menú.</p>
                            <?php if (!empty($settings['logo_url'])) : ?>
                                <img class="msa-logo-preview" src="<?php echo esc_url($settings['logo_url']); ?>" alt="Vista previa del logo">
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="msa-header-layout">Layout</label></th>
                        <td>
                            <select
                                id="msa-header-layout"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[header_layout]"
                            >
                                <option value="center" <?php selected($settings['header_layout'], 'center'); ?>>
                                    Centrado (logo arriba)
                                </option>
                                <option value="logo-right" <?php selected($settings['header_layout'], 'logo-right'); ?>>
                                    Logo a la derecha / texto a la izquierda
                                </option>
                                <option value="logo-left" <?php selected($settings['header_layout'], 'logo-left'); ?>>
                                    Logo a la izquierda / texto a la derecha
                                </option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h2 class="title">Sistemas</h2>
            <div id="msa-items">
                <?php foreach ($settings['items'] as $item_index => $item) : ?>
                    <div class="msa-item-block" data-item-index="<?php echo esc_attr((string) $item_index); ?>">
                        <table class="form-table" role="presentation">
                            <tbody>
                                <tr>
                                    <th scope="row"><label>Nombre del sistema</label></th>
                                    <td>
                                        <input
                                            type="text"
                                            class="regular-text"
                                            name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][<?php echo esc_attr((string) $item_index); ?>][title]"
                                            value="<?php echo esc_attr($item['title']); ?>"
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label>Descripción</label></th>
                                    <td>
                                        <input
                                            type="text"
                                            class="regular-text"
                                            name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][<?php echo esc_attr((string) $item_index); ?>][description]"
                                            value="<?php echo esc_attr($item['description']); ?>"
                                        >
                                    </td>
                                </tr>
                                <?php foreach ($item['links'] as $link_index => $link) : ?>
                                    <tr>
                                        <th scope="row"><label>Acceso <?php echo esc_html((string) ($link_index + 1)); ?></label></th>
                                        <td>
                                            <div class="msa-link-row" data-link-index="<?php echo esc_attr((string) $link_index); ?>">
                                                <input
                                                    type="text"
                                                    class="regular-text"
                                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][<?php echo esc_attr((string) $item_index); ?>][links][<?php echo esc_attr((string) $link_index); ?>][label]"
                                                    value="<?php echo esc_attr($link['label']); ?>"
                                                    placeholder="Nombre del botón"
                                                >
                                                <input
                                                    type="url"
                                                    class="regular-text"
                                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][<?php echo esc_attr((string) $item_index); ?>][links][<?php echo esc_attr((string) $link_index); ?>][url]"
                                                    value="<?php echo esc_url($link['url']); ?>"
                                                    placeholder="https://"
                                                >
                                                <button type="button" class="button msa-remove-link">Quitar</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th scope="row"></th>
                                    <td>
                                        <button type="button" class="button msa-add-link">Agregar acceso</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="msa-actions">
                <button type="button" class="button" id="msa-add-item">Agregar sistema</button>
            </div>
            <?php submit_button('Guardar cambios'); ?>
        </form>
    </div>
    <script type="text/template" id="msa-item-template">
        <div class="msa-item-block" data-item-index="{{index}}">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row"><label>Nombre del sistema</label></th>
                        <td>
                            <input
                                type="text"
                                class="regular-text"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][title]"
                                value=""
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Descripción</label></th>
                        <td>
                            <input
                                type="text"
                                class="regular-text"
                                name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][description]"
                                value=""
                            >
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Acceso 1</label></th>
                        <td>
                            <div class="msa-link-row" data-link-index="0">
                                <input
                                    type="text"
                                    class="regular-text"
                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][links][0][label]"
                                    value=""
                                    placeholder="Nombre del botón"
                                >
                                <input
                                    type="url"
                                    class="regular-text"
                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][links][0][url]"
                                    value=""
                                    placeholder="https://"
                                >
                                <button type="button" class="button msa-remove-link">Quitar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label>Acceso 2</label></th>
                        <td>
                            <div class="msa-link-row" data-link-index="1">
                                <input
                                    type="text"
                                    class="regular-text"
                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][links][1][label]"
                                    value=""
                                    placeholder="Nombre del botón"
                                >
                                <input
                                    type="url"
                                    class="regular-text"
                                    name="<?php echo esc_attr(MENU_SISTEMAS_AGROCAMPO_OPTION); ?>[items][{{index}}][links][1][url]"
                                    value=""
                                    placeholder="https://"
                                >
                                <button type="button" class="button msa-remove-link">Quitar</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <button type="button" class="button msa-add-link">Agregar acceso</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>
    <?php
}

/**
 * Flush rewrite rules on activation/deactivation.
 */
function msa_flush_rewrite_rules(): void
{
    msa_register_rewrite_rule();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'msa_flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
