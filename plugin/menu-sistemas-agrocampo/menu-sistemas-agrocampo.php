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
 * Render the menu markup.
 */
function msa_render_menu(): string
{
    wp_enqueue_style('menu-sistemas-agrocampo-style');

    $items = [
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
    ];

    ob_start();
    ?>
    <section class="msa-menu" aria-label="Menú Sistemas Agrocampo">
        <header class="msa-menu__header">
            <h2 class="msa-menu__title">Menú Sistemas Agrocampo</h2>
            <p class="msa-menu__subtitle">Acceso rápido a los sistemas de gestión.</p>
        </header>
        <div class="msa-menu__grid">
            <?php foreach ($items as $item) : ?>
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
 * Flush rewrite rules on activation/deactivation.
 */
function msa_flush_rewrite_rules(): void
{
    msa_register_rewrite_rule();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'msa_flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');
