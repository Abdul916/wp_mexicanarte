<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Task_Theme extends AutoUpdater_Upgrader_Task_Base
{

    /**
     * @param string $slug
     * @param string $path
     *
     * @return mixed
     * @throws
     */
    public function update($slug, $path = '')
    {
        AutoUpdater_Log::debug('Starting to update theme: ' . $slug);

        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Theme.php';
        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Skin/Theme.php';

        $theme_path = WP_CONTENT_DIR . '/themes/' . $slug . '/style.css';
        if (!AutoUpdater_Filemanager::getInstance()->exists($theme_path)) {
            AutoUpdater_Log::error('Theme directory not found: ' . $theme_path);
            $theme_path = AutoUpdater_Helper_Extension::getThemeRealPath($slug);
            if (!$theme_path) {
                throw AutoUpdater_Exception_Response::getException(
                    200,
                    'Failed to update theme: ' . $slug,
                    'no_update_warning',
                    'No update was performed, theme directory not found'
                );
            }
            AutoUpdater_Log::error('Changing theme directory to: ' . $theme_path);
        }

        $data = get_file_data($theme_path, array('Version' => 'Version'));
        $this->task->old_version = $data['Version'];

        if ($path) {
            $nonce = 'theme-upload';
            $url = add_query_arg(array('package' => $path), 'update.php?action=upload-theme');
            $type = 'upload'; //Install theme type, From Web or an Upload.
        } else {
            $theme = $slug;
            $nonce = 'upgrade-theme_' . $theme;
            $url = 'update.php?action=upgrade-theme&theme=' . rawurlencode($theme);
            $type = 'theme';
        }

        ob_start();

        $this->task->upgrader = new AutoUpdater_Upgrader_Theme(
            new AutoUpdater_Upgrader_Skin_Theme(
                @compact('nonce', 'url', 'theme', 'type')
            )
        );
        // don't clear update cache, so next theme's update step in same action will be able to use update cache data
        $result = $path ? $this->task->upgrader->install($path, array('clear_update_cache' => false)) : $this->task->upgrader->upgrade($slug, array('clear_update_cache' => false));

        $output = ob_get_clean();
        if (!empty($output)) {
            AutoUpdater_Log::debug('Updater output: ' . $output);
        }

        $data = get_file_data($theme_path, array('Version' => 'Version'));
        $this->task->new_version = $data['Version'];

        return $result;
    }

}
