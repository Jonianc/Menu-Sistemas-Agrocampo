<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Deactivator
{
    private const CAPABILITY = 'manage_msa_menu';

    public static function deactivate(): void
    {
        $administrator_role = get_role('administrator');
        if ($administrator_role instanceof WP_Role) {
            $administrator_role->remove_cap(self::CAPABILITY);
        }

        $editor_role = get_role('editor');
        if ($editor_role instanceof WP_Role) {
            $editor_role->remove_cap(self::CAPABILITY);
        }

        flush_rewrite_rules();
    }
}
