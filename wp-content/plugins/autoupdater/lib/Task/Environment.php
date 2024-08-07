<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_Environment extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        global $wpdb;

        $data = array(
            'success' => true,
            'core_version' => AUTOUPDATER_WP_VERSION,
            'site_language' => AutoUpdater_Config::getSiteLanguage(),
            'is_main_site' => is_main_site(),
            'is_multisite' => is_multisite(),
            'php_version' => php_sapi_name() !== 'cli' ? PHP_VERSION : '',
            'os' => function_exists('php_uname') && is_callable('php_uname') ? @php_uname('s') : '',
            'server' => isset($_SERVER['SERVER_SOFTWARE']) ? wp_unslash(sanitize_text_field($_SERVER['SERVER_SOFTWARE'])) : '',
            /** $wpdb->is_mysql @since 3.3.0 */
            'database_name' => version_compare(AUTOUPDATER_WP_VERSION, '3.3.0', '<') || $wpdb->is_mysql ? 'MySQL' : '',
            'database_version' => $wpdb->db_version(),
            'hostname' => gethostname(),
            'git' => AutoUpdater_Filemanager::getInstance()->exists(AUTOUPDATER_SITE_PATH . '.git'),
            'install_name' => defined('PWP_NAME') ? PWP_NAME : '',
            'cluster_id' => defined('WPE_CLUSTER_ID') ? WPE_CLUSTER_ID : '',
        );

        $database_version_info = $wpdb->get_var('SELECT version()');
        if (!empty($database_version_info) && strpos(strtolower($database_version_info), 'mariadb') !== false) {
            $data['database_name'] = 'MariaDB';
            $version = explode('-', $database_version_info);
            if (!empty($version[0])) {
                $data['database_version'] = $version[0];
            }
        }

        return $data;
    }
}
