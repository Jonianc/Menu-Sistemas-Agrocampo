<?php
/**
 * Plugin Name: Menú Sistemas Agrocampo
 * Description: Menú standalone en frontend para gestionar sistemas de Agrocampo.
 * Version: 1.2.2
 * Author: Agrocampo
 * License: GPL-2.0-or-later
 * Text Domain: menu-sistemas-agrocampo
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MSA_PLUGIN_VERSION', '1.2.2');
define('MSA_PLUGIN_FILE', __FILE__);
define('MSA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MSA_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once MSA_PLUGIN_DIR . 'includes/class-msa-plugin.php';
require_once MSA_PLUGIN_DIR . 'includes/class-msa-settings.php';
require_once MSA_PLUGIN_DIR . 'includes/class-msa-admin.php';
require_once MSA_PLUGIN_DIR . 'includes/class-msa-frontend.php';
require_once MSA_PLUGIN_DIR . 'includes/class-msa-activator.php';
require_once MSA_PLUGIN_DIR . 'includes/class-msa-deactivator.php';

register_activation_hook(__FILE__, ['MSA_Activator', 'activate']);
register_deactivation_hook(__FILE__, ['MSA_Deactivator', 'deactivate']);

function msa_run_plugin(): void
{
    $plugin = new MSA_Plugin();
    $plugin->run();
}

msa_run_plugin();
