<?php

if (!defined('ABSPATH')) {
    exit;
}

class MSA_Deactivator
{
    public static function deactivate(): void
    {
        flush_rewrite_rules();
    }
}
