<?php
/**
 * Admin settings template.
 *
 * @var array $settings
 * @var string $option_key
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo esc_html__('Menú Sistemas Agrocampo', 'menu-sistemas-agrocampo'); ?></h1>
    <form method="post" action="options.php">
        <?php settings_fields('msa_menu_settings_group'); ?>

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
            </tbody>
        </table>

        <h2 class="title"><?php echo esc_html__('Sistemas', 'menu-sistemas-agrocampo'); ?></h2>
        <div id="msa-items">
            <p class="description msa-empty-state" <?php if (!empty($settings['items'])) : ?>style="display:none;"<?php endif; ?>>
                <?php echo esc_html__('No hay sistemas configurados. Agrega uno para comenzar.', 'menu-sistemas-agrocampo'); ?>
            </p>
            <?php foreach ($settings['items'] as $item_index => $item) : ?>
                <div class="msa-item-block" data-item-index="<?php echo esc_attr((string) $item_index); ?>">
                    <div class="msa-item-block__actions">
                        <button type="button" class="button msa-drag-item" aria-label="<?php echo esc_attr__('Arrastrar sistema', 'menu-sistemas-agrocampo'); ?>">
                            <span class="dashicons dashicons-move"></span>
                            <?php echo esc_html__('Arrastrar', 'menu-sistemas-agrocampo'); ?>
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

        <?php submit_button(__('Guardar cambios', 'menu-sistemas-agrocampo')); ?>
    </form>
</div>

<script type="text/template" id="msa-item-template">
    <div class="msa-item-block" data-item-index="{{index}}">
        <div class="msa-item-block__actions">
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
