<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Activator
{
    private const CAPABILITY = 'manage_msa_menu';

    public static function activate(): void
    {
        $administrator_role = get_role('administrator');
        if ($administrator_role instanceof WP_Role) {
            $administrator_role->add_cap(self::CAPABILITY);
        }

        $editor_role = get_role('editor');
        if ($editor_role instanceof WP_Role) {
            $editor_role->add_cap(self::CAPABILITY);
        }

        add_rewrite_rule('^menu-sistemas-agrocampo/?$', 'index.php?msa_menu=1', 'top');
        flush_rewrite_rules();
    }
}
