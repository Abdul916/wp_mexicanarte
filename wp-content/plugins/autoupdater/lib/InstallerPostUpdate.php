<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_InstallerPostUpdate
{
    /**
     * @param string $old_version
     * @param string $new_version
     *
     * @return bool
     */
    public static function run($old_version, $new_version)
    {
        if (version_compare($old_version, '2.0', '<')) {
            AutoUpdater_Log::debug('Migrating settings');

            AutoUpdater_Config::set('worker_token', AutoUpdater_Config::get('write_token'));
            AutoUpdater_Config::set('update_plugins', AutoUpdater_Config::get('update_extensions', 1));
            AutoUpdater_Config::set('notification_emails', AutoUpdater_Config::get('notification_end_user_email'));

            $time_of_day = AutoUpdater_Config::get('time_of_day', 'afternoon');
            $day_periods = array(
                'night' => 0,
                'morning' => 6,
                'afternoon' => 12,
                'evening' => 18
            );
            AutoUpdater_Config::set('autoupdate_at', array_key_exists($time_of_day, $day_periods) ? $day_periods[$time_of_day] : 12);

            $excludedSlugsMigrationFunction = function ($value) {
                list(, $slug) = explode('::', $value, 2);
                return $slug;
            };

            $excluded_plugins = (array) AutoUpdater_Config::get('excluded_extensions', array());
            if (!empty($excluded_plugins)) {
                $excluded_plugins = array_map($excludedSlugsMigrationFunction, $excluded_plugins);
                AutoUpdater_Config::set('excluded_plugins', $excluded_plugins);
            }

            $excluded_themes = (array) AutoUpdater_Config::get('excluded_themes', array());
            if (!empty($excluded_themes)) {
                $excluded_plugins = array_map($excludedSlugsMigrationFunction, $excluded_themes);
                AutoUpdater_Config::set('excluded_themes', $excluded_themes);
            }

            AutoUpdater_Config::remove('read_token');
            AutoUpdater_Config::remove('write_token');
            AutoUpdater_Config::remove('update_cms');
            AutoUpdater_Config::remove('update_cms_stage');
            AutoUpdater_Config::remove('update_extensions');
            AutoUpdater_Config::remove('excluded_extensions');
            AutoUpdater_Config::remove('notification_end_user_email');
            AutoUpdater_Config::remove('time_of_day');
            AutoUpdater_Config::remove('config_cached');

            // Migrate logs files
            $old_path = rtrim(WP_CONTENT_DIR, '/\\') . '/logs/';
            $new_path = AutoUpdater_Log::getInstance()->getLogsPath();
            $filemanager = AutoUpdater_Filemanager::getInstance();
            if (!$filemanager->is_dir($new_path)) {
                $filemanager->mkdir($new_path);
            }
            $files = $filemanager->dirlist($old_path, false);
            if (is_array($files)) {
                foreach ($files as $file => $fileinfo) {
                    if (strpos($file, 'autoupdater_') === 0) {
                        $filemanager->move($old_path . $file, $new_path . $file);
                    }
                }
            }
            // Delete empty old path
            $files = $filemanager->dirlist($old_path, false);
            if (is_array($files) && !count($files)) {
                $filemanager->delete($old_path);
            }
        }
        if (version_compare($old_version, '2.0.5', '<')) {
            AutoUpdater_Log::debug('Migrating settings');
            AutoUpdater_Config::set('encrypt_response', AutoUpdater_Config::get('encryption'));
            AutoUpdater_Config::remove('encryption');
        }
        if (version_compare($old_version, '3.1.0', '<')) {
            AutoUpdater_Config::remove('extensions_cache');
            AutoUpdater_Config::remove('extensions_cached_at');
        }

        return true;
    }
}
