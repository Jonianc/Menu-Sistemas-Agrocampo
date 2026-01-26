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
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <?php echo esc_html($settings['quick_access_label']); ?>
                </a>
            <?php endif; ?>
        </header>
        <div class="msa-menu__grid">
            <?php foreach ($settings['items'] as $item) : ?>
                <article class="msa-menu__card">
                    <h2 class="msa-menu__card-title"><?php echo esc_html($item['title']); ?></h2>
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
</body>
</html>
