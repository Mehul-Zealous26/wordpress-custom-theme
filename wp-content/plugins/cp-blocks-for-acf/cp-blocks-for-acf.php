<?php
/*
Plugin Name: Copy/Paste FlexContent Blocks for ACF
Description: Feature for ACF that allows copy-paste flexible blocks.
Version:     0.4.2
Author:      Miroslav Curcic
Author URI:  https://profiles.wordpress.org/tekod
Text Domain: cp-blocks-for-acf
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
License:     GPL v2 or later
*/

// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
defined('ABSPATH') || die();

// prevent fatal error if clone of plugin is activated, remember: no function or class declarations in this file
if (defined('CPBLOCKSFORACF_PLUGINBASENAME')) {
    return;
}

// critical requirements check
if (version_compare(PHP_VERSION, '7.0') < 0) {
    return;
}

// prepare plugin constants
define('CPBLOCKSFORACF_PLUGINBASENAME', plugin_basename(__FILE__));
define('CPBLOCKSFORACF_DIR', __DIR__);
define('CPBLOCKSFORACF_VERSION', '0.4.2'); // plugin version

// run plugin
require_once __DIR__ . '/src/Bootstrap.php';
Tekod\CpBlocksForACF\Bootstrap::init();
