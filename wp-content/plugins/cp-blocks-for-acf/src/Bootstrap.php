<?php

declare(strict_types=1);
namespace Tekod\CpBlocksForACF;


/**
 * Class Bootstrap.
 */
class Bootstrap
{

    // list of unmatched requirements
    protected static $requirements = [];


    /**
     * Start all services.
     */
    public static function init()
    {
        // wait all other plugins to load to continue
        add_action('plugins_loaded', [__CLASS__, 'lateInitialization']);
    }


    /**
     * Deferred tasks for plugin initialization.
     * In this point all other plugins are loaded, so we can check for requirements.
     */
    public static function lateInitialization()
    {
        // we don't want to run high-level functionalities during uninstall process
        if (defined('WP_UNINSTALL_PLUGIN')) {
            return;
        }

        // check are requirements met
        static::requirementsCheck();

        // initialize admin-side systems
        if (is_admin()) {
            static::initAdminSystems();
        }
    }


    /**
     * Initialize features that are needed only on admin side.
     */
    protected static function initAdminSystems()
    {
        // display notice about unmatched requirements
        if (!empty(static::$requirements)) {
            add_action('admin_notices', static function () {
                $message = '"Copy/Paste FlexContent Blocks for ACF" requirements: ' . nl2br(esc_html(implode("\n", static::$requirements)));
                echo '<div class="error"><p>' . wp_kses_post($message) . '</p></div>';
            });
        }

        // enqueue assets
        add_action('admin_init', [__CLASS__, 'onAdminInit']);

        // conditional hook for newer version of ACF plugin
        $acfVersion = function_exists('acf_get_setting') ? strval(acf_get_setting('version')) : '';
        if (version_compare($acfVersion, '6.5.0', '>=')) {
            add_action('acf/render_field/type=flexible_content', [__CLASS__, 'onRenderFlexContentBox'], 99);
        }
    }


    /**
     * Check are all plugin requirements are meet.
     * It should populate list of error messages about missing requirements.
     */
    protected static function requirementsCheck(): void
    {
        static::$requirements = [];

        // check plugins
        if (!class_exists('acf_pro')) {
            static::$requirements[] = 'Missing "Advanced Custom Fields PRO" plugin.';
        }
        if (defined('ACF_VERSION') && version_compare(constant('ACF_VERSION'), '6.0') < 0) {
            static::$requirements[] = 'Requires ACF plugin at least version 6.0.';
        }

        // check PHP version
        if (version_compare(PHP_VERSION, '7.4') < 0) {
            static::$requirements['PHP version'] = 'PHP version 7.4 or newer';
        }
    }


    /**
     * Enqueue javascript and css files.
     */
    public static function onAdminInit(): void
    {
        // allow 3rd-party to disable enqueuing assets
        if (!apply_filters('cp-blocks-for-acf-enqueue_assets', true)) {
            return;
        }

        // enqueue
        $pluginURL = untrailingslashit(plugin_dir_url(CPBLOCKSFORACF_DIR . '/.'));
        wp_enqueue_script('cp-blocks-for-acf-js', "$pluginURL/assets/cp-blocks-for-acf.js", ['jquery'], CPBLOCKSFORACF_VERSION, false);
        wp_enqueue_style('cp-blocks-for-acf-css', "$pluginURL/assets/cp-blocks-for-acf.css", [], CPBLOCKSFORACF_VERSION);
    }


    /**
     * Inject new option in popup (since ACF plugin version 6.5+).
     */
    public static function onRenderFlexContentBox()
    {
        echo '
        <script type="text/javascript">
            var search = "<a class=\"acf-rename-layout\"";
            var newOption = "<a class=\"acf-copy-layout\" data-action=\"copy-layout\" href=\"#\" role=\"menuitem\">Copy Layout</a>";
            var nodes = document.querySelectorAll(".tmpl-more-layout-actions");
			if (nodes.length) {
			    nodes[nodes.length-1].textContent = nodes[nodes.length-1].textContent.replace(search, newOption + "</li> \n <li>" + search);
			}
        </script>
        ';
    }

}
