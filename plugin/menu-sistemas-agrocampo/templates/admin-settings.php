<?php
/**
 * Admin settings template.
 *
 * @var array $settings
 * @var string $option_key
 * @var string $allowed_hosts_text
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo esc_html__('Menú Sistemas Agrocampo', 'menu-sistemas-agrocampo'); ?></h1>
    <div class="msa-quick-route">
        <p><strong><?php echo esc_html__('Ruta pública del menú:', 'menu-sistemas-agrocampo'); ?></strong></p>
        <code><?php echo esc_html($menu_url); ?></code>
        <a class="button button-secondary" href="<?php echo esc_url($menu_url); ?>" target="_blank" rel="noopener noreferrer">
            <?php echo esc_html__('Abrir menú', 'menu-sistemas-agrocampo'); ?>
        </a>
    </div>
    <form method="post" action="options.php">
        <?php settings_fields('msa_menu_settings_group'); ?>
        <?php wp_nonce_field('msa_admin_actions', 'msa_admin_nonce'); ?>

        <h2 class="title"><?php echo esc_html__('Header', 'menu-sistemas-agrocampo'); ?></h2>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="msa-title"><?php echo esc_html__('Título', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            id="msa-title"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[title]"
                            value="<?php echo esc_attr($settings['title']); ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="msa-subtitle"><?php echo esc_html__('Subtítulo', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            id="msa-subtitle"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[subtitle]"
                            value="<?php echo esc_attr($settings['subtitle']); ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="msa-logo-url"><?php echo esc_html__('Logo', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            id="msa-logo-url"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[logo_url]"
                            value="<?php echo esc_url($settings['logo_url']); ?>"
                        >
                        <button type="button" class="button msa-upload-logo">
                            <?php echo esc_html__('Subir logo', 'menu-sistemas-agrocampo'); ?>
                        </button>
                        <p class="description">
                            <?php echo esc_html__('Sube o selecciona el logo para mostrar en el menú.', 'menu-sistemas-agrocampo'); ?>
                        </p>
                        <?php if (!empty($settings['logo_url'])) : ?>
                            <img class="msa-logo-preview" src="<?php echo esc_url($settings['logo_url']); ?>" alt="<?php echo esc_attr__('Vista previa del logo', 'menu-sistemas-agrocampo'); ?>">
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="msa-header-layout"><?php echo esc_html__('Layout', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <select id="msa-header-layout" name="<?php echo esc_attr($option_key); ?>[header_layout]">
                            <option value="center" <?php selected($settings['header_layout'], 'center'); ?>>
                                <?php echo esc_html__('Centrado (logo arriba)', 'menu-sistemas-agrocampo'); ?>
                            </option>
                            <option value="logo-right" <?php selected($settings['header_layout'], 'logo-right'); ?>>
                                <?php echo esc_html__('Logo a la derecha / texto a la izquierda', 'menu-sistemas-agrocampo'); ?>
                            </option>
                            <option value="logo-left" <?php selected($settings['header_layout'], 'logo-left'); ?>>
                                <?php echo esc_html__('Logo a la izquierda / texto a la derecha', 'menu-sistemas-agrocampo'); ?>
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="msa-quick-access-label"><?php echo esc_html__('Acceso rápido', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            id="msa-quick-access-label"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[quick_access_label]"
                            value="<?php echo esc_attr($settings['quick_access_label']); ?>"
                            placeholder="<?php echo esc_attr__('Texto del botón', 'menu-sistemas-agrocampo'); ?>"
                        >
                        <input
                            type="url"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[quick_access_url]"
                            value="<?php echo esc_url($settings['quick_access_url']); ?>"
                            placeholder="https://"
                        >
                        <p class="description">
                            <?php echo esc_html__('Enlace adicional mostrado en el header del menú.', 'menu-sistemas-agrocampo'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="msa-link-target"><?php echo esc_html__('Apertura de enlaces', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <select id="msa-link-target" name="<?php echo esc_attr($option_key); ?>[link_target]">
                            <option value="_blank" <?php selected($settings['link_target'], '_blank'); ?>>
                                <?php echo esc_html__('Nueva pestaña', 'menu-sistemas-agrocampo'); ?>
                            </option>
                            <option value="_self" <?php selected($settings['link_target'], '_self'); ?>>
                                <?php echo esc_html__('Misma pestaña', 'menu-sistemas-agrocampo'); ?>
                            </option>
                        </select>
                        <p class="description"><?php echo esc_html__('Aplica al botón de acceso rápido y accesos de cada sistema.', 'menu-sistemas-agrocampo'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><label for="msa-allowed-hosts"><?php echo esc_html__('Hosts permitidos (opcional)', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <textarea
                            id="msa-allowed-hosts"
                            class="large-text"
                            rows="4"
                            name="<?php echo esc_attr($option_key); ?>[allowed_hosts]"
                            placeholder="sistemas.agrocampo.cl&#10;intranet.agrocampo.cl"
                        ><?php echo esc_textarea($allowed_hosts_text); ?></textarea>
                        <p class="description"><?php echo esc_html__('Ingresa un host por línea (o separados por coma). Si se define esta lista, solo se guardarán URLs de acceso rápido y accesos de sistemas que pertenezcan a esos hosts.', 'menu-sistemas-agrocampo'); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 class="title"><?php echo esc_html__('Sistemas', 'menu-sistemas-agrocampo'); ?></h2>
        <p id="msa-sort-announcer" class="screen-reader-text" aria-live="polite"></p>
        <div id="msa-items">
            <p class="description msa-empty-state" <?php if (!empty($settings['items'])) : ?>style="display:none;"<?php endif; ?>>
                <?php echo esc_html__('No hay sistemas configurados. Agrega uno para comenzar.', 'menu-sistemas-agrocampo'); ?>
            </p>
            <?php foreach ($settings['items'] as $item_index => $item) : ?>
                <div class="msa-item-block" data-item-index="<?php echo esc_attr((string) $item_index); ?>">
                    <div class="msa-item-block__actions">
                        <span class="msa-drag-item" role="button" tabindex="0" aria-label="<?php echo esc_attr__('Arrastrar sistema', 'menu-sistemas-agrocampo'); ?>">
                            <span class="dashicons dashicons-move" aria-hidden="true"></span>
                            <?php echo esc_html__('Arrastrar', 'menu-sistemas-agrocampo'); ?>
                        </span>
                        <button type="button" class="button msa-move-up" aria-label="<?php echo esc_attr__('Mover sistema hacia arriba', 'menu-sistemas-agrocampo'); ?>">
                            <?php echo esc_html__('Subir', 'menu-sistemas-agrocampo'); ?>
                        </button>
                        <button type="button" class="button msa-move-down" aria-label="<?php echo esc_attr__('Mover sistema hacia abajo', 'menu-sistemas-agrocampo'); ?>">
                            <?php echo esc_html__('Bajar', 'menu-sistemas-agrocampo'); ?>
                        </button>
                        <button type="button" class="button button-link-delete msa-remove-item">
                            <?php echo esc_html__('Eliminar sistema', 'menu-sistemas-agrocampo'); ?>
                        </button>
                    </div>
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row"><label><?php echo esc_html__('Nombre del sistema', 'menu-sistemas-agrocampo'); ?></label></th>
                                <td>
                                    <input
                                        type="text"
                                        class="regular-text"
                                        name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][title]"
                                        value="<?php echo esc_attr($item['title']); ?>"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php echo esc_html__('Descripción', 'menu-sistemas-agrocampo'); ?></label></th>
                                <td>
                                    <input
                                        type="text"
                                        class="regular-text"
                                        name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][description]"
                                        value="<?php echo esc_attr($item['description']); ?>"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php echo esc_html__('Etiqueta (opcional)', 'menu-sistemas-agrocampo'); ?></label></th>
                                <td>
                                    <input
                                        type="text"
                                        class="regular-text"
                                        name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][badge]"
                                        value="<?php echo esc_attr($item['badge'] ?? ''); ?>"
                                        placeholder="Nuevo / Mantenimiento"
                                    >
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label><?php echo esc_html__('Visibilidad', 'menu-sistemas-agrocampo'); ?></label></th>
                                <td>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][hidden]"
                                            value="1"
                                            <?php checked(!empty($item['hidden'])); ?>
                                        >
                                        <?php echo esc_html__('Ocultar temporalmente este sistema', 'menu-sistemas-agrocampo'); ?>
                                    </label>
                                </td>
                            </tr>
                            <?php foreach ($item['links'] as $link_index => $link) : ?>
                                <tr>
                                    <th scope="row"><label><?php echo esc_html(sprintf(__('Acceso %d', 'menu-sistemas-agrocampo'), $link_index + 1)); ?></label></th>
                                    <td>
                                        <div class="msa-link-row" data-link-index="<?php echo esc_attr((string) $link_index); ?>">
                                            <input
                                                type="text"
                                                class="regular-text"
                                                name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][links][<?php echo esc_attr((string) $link_index); ?>][label]"
                                                value="<?php echo esc_attr($link['label']); ?>"
                                                placeholder="<?php echo esc_attr__('Nombre del botón', 'menu-sistemas-agrocampo'); ?>"
                                            >
                                            <input
                                                type="url"
                                                class="regular-text"
                                                name="<?php echo esc_attr($option_key); ?>[items][<?php echo esc_attr((string) $item_index); ?>][links][<?php echo esc_attr((string) $link_index); ?>][url]"
                                                value="<?php echo esc_url($link['url']); ?>"
                                                placeholder="https://"
                                            >
                                            <button type="button" class="button msa-remove-link">
                                                <?php echo esc_html__('Quitar', 'menu-sistemas-agrocampo'); ?>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th scope="row"></th>
                                <td>
                                    <button type="button" class="button msa-add-link">
                                        <?php echo esc_html__('Agregar acceso', 'menu-sistemas-agrocampo'); ?>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="msa-actions">
            <button type="button" class="button" id="msa-add-item">
                <?php echo esc_html__('Agregar sistema', 'menu-sistemas-agrocampo'); ?>
            </button>
        </div>

        <h2 class="title"><?php echo esc_html__('Vista previa', 'menu-sistemas-agrocampo'); ?></h2>
        <p class="description"><?php echo esc_html__('Esta vista se actualiza automáticamente mientras editas los campos.', 'menu-sistemas-agrocampo'); ?></p>
        <section class="msa-admin-preview" aria-live="polite" aria-label="<?php echo esc_attr__('Vista previa del menú', 'menu-sistemas-agrocampo'); ?>">
            <header id="msa-preview-header" class="msa-admin-preview__header msa-admin-preview__header--center">
                <img id="msa-preview-logo" class="msa-admin-preview__logo" src="" alt="<?php echo esc_attr__('Logo del menú', 'menu-sistemas-agrocampo'); ?>" hidden>
                <div class="msa-admin-preview__text">
                    <h3 id="msa-preview-title" class="msa-admin-preview__title"></h3>
                    <p id="msa-preview-subtitle" class="msa-admin-preview__subtitle"></p>
                </div>
                <a id="msa-preview-quick-link" class="msa-admin-preview__quick-link" href="#" target="_blank" rel="noopener noreferrer" hidden></a>
            </header>
            <div id="msa-preview-grid" class="msa-admin-preview__grid"></div>
        </section>

        <?php submit_button(__('Guardar cambios', 'menu-sistemas-agrocampo')); ?>
    </form>
</div>

<script type="text/template" id="msa-item-template">
    <div class="msa-item-block" data-item-index="{{index}}">
        <div class="msa-item-block__actions">
            <span class="msa-drag-item" role="button" tabindex="0" aria-label="<?php echo esc_attr__('Arrastrar sistema', 'menu-sistemas-agrocampo'); ?>">
                <span class="dashicons dashicons-move" aria-hidden="true"></span>
                <?php echo esc_html__('Arrastrar', 'menu-sistemas-agrocampo'); ?>
            </span>
            <button type="button" class="button msa-move-up" aria-label="<?php echo esc_attr__('Mover sistema hacia arriba', 'menu-sistemas-agrocampo'); ?>">
                <?php echo esc_html__('Subir', 'menu-sistemas-agrocampo'); ?>
            </button>
            <button type="button" class="button msa-move-down" aria-label="<?php echo esc_attr__('Mover sistema hacia abajo', 'menu-sistemas-agrocampo'); ?>">
                <?php echo esc_html__('Bajar', 'menu-sistemas-agrocampo'); ?>
            </button>
            <button type="button" class="button button-link-delete msa-remove-item">
                <?php echo esc_html__('Eliminar sistema', 'menu-sistemas-agrocampo'); ?>
            </button>
        </div>
        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Nombre del sistema', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[items][{{index}}][title]"
                            value=""
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Descripción', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[items][{{index}}][description]"
                            value=""
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Etiqueta (opcional)', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <input
                            type="text"
                            class="regular-text"
                            name="<?php echo esc_attr($option_key); ?>[items][{{index}}][badge]"
                            value=""
                            placeholder="Nuevo / Mantenimiento"
                        >
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Visibilidad', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <label>
                            <input
                                type="checkbox"
                                name="<?php echo esc_attr($option_key); ?>[items][{{index}}][hidden]"
                                value="1"
                            >
                            <?php echo esc_html__('Ocultar temporalmente este sistema', 'menu-sistemas-agrocampo'); ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Acceso 1', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <div class="msa-link-row" data-link-index="0">
                            <input
                                type="text"
                                class="regular-text"
                                name="<?php echo esc_attr($option_key); ?>[items][{{index}}][links][0][label]"
                                value=""
                                placeholder="<?php echo esc_attr__('Nombre del botón', 'menu-sistemas-agrocampo'); ?>"
                            >
                            <input
                                type="url"
                                class="regular-text"
                                name="<?php echo esc_attr($option_key); ?>[items][{{index}}][links][0][url]"
                                value=""
                                placeholder="https://"
                            >
                            <button type="button" class="button msa-remove-link">
                                <?php echo esc_html__('Quitar', 'menu-sistemas-agrocampo'); ?>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label><?php echo esc_html__('Acceso 2', 'menu-sistemas-agrocampo'); ?></label></th>
                    <td>
                        <div class="msa-link-row" data-link-index="1">
                            <input
                                type="text"
                                class="regular-text"
                                name="<?php echo esc_attr($option_key); ?>[items][{{index}}][links][1][label]"
                                value=""
                                placeholder="<?php echo esc_attr__('Nombre del botón', 'menu-sistemas-agrocampo'); ?>"
                            >
                            <input
                                type="url"
                                class="regular-text"
                                name="<?php echo esc_attr($option_key); ?>[items][{{index}}][links][1][url]"
                                value=""
                                placeholder="https://"
                            >
                            <button type="button" class="button msa-remove-link">
                                <?php echo esc_html__('Quitar', 'menu-sistemas-agrocampo'); ?>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <button type="button" class="button msa-add-link">
                            <?php echo esc_html__('Agregar acceso', 'menu-sistemas-agrocampo'); ?>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</script>
