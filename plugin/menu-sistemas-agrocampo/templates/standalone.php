<?php
/**
 * Standalone frontend template.
 *
 * @var array $settings
 * @var string $css_url
 */

if (!defined('ABSPATH')) {
    exit;
}

$header_class = 'msa-menu__header--' . $settings['header_layout'];
$link_target = $settings['link_target'] ?? '_blank';
if (!in_array($link_target, ['_blank', '_self'], true)) {
    $link_target = '_blank';
}
$link_rel = $link_target === '_blank' ? 'noopener noreferrer' : '';
$visible_items = array_values(array_filter($settings['items'], static function (array $item): bool {
    return empty($item['hidden']);
}));
$visible_items = array_map(static function (array $item): array {
    $item['links'] = array_values(array_filter($item['links'] ?? [], static function (array $link): bool {
        $label = isset($link['label']) ? trim((string) $link['label']) : '';
        $url = isset($link['url']) ? trim((string) $link['url']) : '';

        return $label !== '' && $url !== '';
    }));

    return $item;
}, $visible_items);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html__('Menú Sistemas Agrocampo', 'menu-sistemas-agrocampo'); ?></title>
    <link rel="stylesheet" href="<?php echo esc_url($css_url); ?>">
</head>
<body>
    <section class="msa-menu" aria-label="<?php echo esc_attr__('Menú Sistemas Agrocampo', 'menu-sistemas-agrocampo'); ?>">
        <header class="msa-menu__header <?php echo esc_attr($header_class); ?>">
            <?php if (!empty($settings['logo_url'])) : ?>
                <img class="msa-menu__logo" src="<?php echo esc_url($settings['logo_url']); ?>" alt="<?php echo esc_attr__('Logo Agrocampo', 'menu-sistemas-agrocampo'); ?>">
            <?php endif; ?>
            <div class="msa-menu__text">
                <h1 class="msa-menu__title"><?php echo esc_html($settings['title']); ?></h1>
                <p class="msa-menu__subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
            </div>
            <?php if (!empty($settings['quick_access_label']) && !empty($settings['quick_access_url'])) : ?>
                <a
                    class="msa-menu__quick-link"
                    href="<?php echo esc_url($settings['quick_access_url']); ?>"
                    target="<?php echo esc_attr($link_target); ?>"
                    <?php if ($link_rel !== '') : ?>rel="<?php echo esc_attr($link_rel); ?>"<?php endif; ?>
                >
                    <?php echo esc_html($settings['quick_access_label']); ?>
                </a>
            <?php endif; ?>
        </header>
        <div class="msa-menu__grid">
            <?php if (empty($visible_items)) : ?>
                <article class="msa-menu__card msa-menu__card--empty">
                    <h2 class="msa-menu__card-title"><?php echo esc_html__('No hay sistemas disponibles', 'menu-sistemas-agrocampo'); ?></h2>
                    <p class="msa-menu__card-description"><?php echo esc_html__('Configura accesos desde el panel de administración.', 'menu-sistemas-agrocampo'); ?></p>
                </article>
            <?php else : ?>
                <?php foreach ($visible_items as $item) : ?>
                    <article class="msa-menu__card">
                        <div class="msa-menu__card-heading">
                            <h2 class="msa-menu__card-title"><?php echo esc_html($item['title']); ?></h2>
                            <?php if (!empty($item['badge'])) : ?>
                                <span class="msa-menu__badge"><?php echo esc_html($item['badge']); ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="msa-menu__card-description"><?php echo esc_html($item['description']); ?></p>
                        <?php if (!empty($item['links'])) : ?>
                            <div class="msa-menu__actions">
                                <?php foreach ($item['links'] as $link) : ?>
                                    <a
                                        class="msa-menu__link"
                                        href="<?php echo esc_url($link['url']); ?>"
                                        target="<?php echo esc_attr($link_target); ?>"
                                        <?php if ($link_rel !== '') : ?>rel="<?php echo esc_attr($link_rel); ?>"<?php endif; ?>
                                    >
                                        <?php echo esc_html($link['label']); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
