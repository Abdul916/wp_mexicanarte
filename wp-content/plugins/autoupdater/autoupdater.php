<?php

/**
 * Plugin Name: WP Engine Smart Plugin Manager
 * Plugin URI:
 * Description: WP Engine Smart Plugin Manager simplifies updates management by automatically updating your plugins and themes every day and ensuring your site continues to work as expected.
 * Version: 5.17.30
 * Text Domain: autoupdater
 * Author: WP Engine
 * Author URI: https://wpengine.com/smart-plugin-manager/
 * License: GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
function_exists('add_action') or die;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if (!defined('AUTOUPDATER_WP_VERSION')) {
    if (!function_exists('AutoUpdater_getWpVersion')) {
        function AutoUpdater_getWpVersion()
        {
            $content = @file_get_contents(ABSPATH . WPINC . '/version.php');
            if ($content && preg_match('/\$wp_version\s*=\s*\'([^\']+)\'/', $content, $match)) {
                return $match[1];
            }
            return $GLOBALS['wp_version'];
        }
    }
    define('AUTOUPDATER_WP_VERSION', AutoUpdater_getWpVersion());
}

if (
    version_compare(AUTOUPDATER_WP_VERSION, '3.0', '>=') &&
    (version_compare(PHP_VERSION, '5.3', '>=') && !defined('WP_CLI') || version_compare(PHP_VERSION, '5.6', '>='))
) {
    $autoupdater_data = get_file_data(__FILE__, array('Name' => 'Plugin Name', 'Author' => 'Author', 'Version' => 'Version'));

    define('AUTOUPDATER_WP_PLUGIN_NAME', $autoupdater_data['Name']);
    define('AUTOUPDATER_WP_PLUGIN_AUTHOR', $autoupdater_data['Author']);
    define('AUTOUPDATER_WP_PLUGIN_FILE', __FILE__);
    define('AUTOUPDATER_WP_PLUGIN_PATH', dirname(__FILE__) . '/');
    define('AUTOUPDATER_WP_PLUGIN_SLUG', plugin_basename(__FILE__));
    define('AUTOUPDATER_WP_PLUGIN_BASENAME', basename(__FILE__, '.php'));

    define('AUTOUPDATER_LIB', true);
    define('AUTOUPDATER_SITE_PATH', rtrim((defined('FLYWHEEL_CONFIG_DIR') ? '/www/' : ABSPATH), '/\\') . '/');
    define('AUTOUPDATER_VERSION', $autoupdater_data['Version']);

    add_filter('auto_update_plugin', '__return_false');

    require_once AUTOUPDATER_WP_PLUGIN_PATH . 'lib/Init.php';

    if (AutoUpdater_Config::get('update_themes', 0)) {
        add_filter('auto_update_theme', '__return_false');
    }

    $autoupdater_api = AutoUpdater_Api::getInstance();

    if (is_admin() || $autoupdater_api->isInitialized() || defined('WP_CLI')) {
        require_once AUTOUPDATER_LIB_PATH . 'Installer.php';
        AutoUpdater_Installer::getInstance();
    }

    require_once AUTOUPDATER_WP_PLUGIN_PATH . 'app/Application.php';

    AutoUpdater_WP_Application::getInstance();
} elseif (!function_exists('autoUpdaterRequirementsNotice') && !defined('WP_CLI')) {
    function autoUpdaterRequirementsNotice()
    {
?>
        <div class="error">
            <p><?php printf(esc_html__('This plugin requires WordPress %s and PHP %s', 'autoupdater'), '3.0+', '5.3+'); ?></p>
        </div>
<?php
    }

    add_action('admin_notices', 'autoUpdaterRequirementsNotice');
}
