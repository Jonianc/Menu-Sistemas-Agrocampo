<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Activator
{
    public static function activate(): void
    {
        add_rewrite_rule('^menu-sistemas-agrocampo/?$', 'index.php?msa_menu=1', 'top');
        flush_rewrite_rules();
    }
}
