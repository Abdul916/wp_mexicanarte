<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Task_Plugin extends AutoUpdater_Upgrader_Task_Base
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
        AutoUpdater_Log::debug('Starting to update plugin: ' . $slug);

        if (substr($slug, -4) !== '.php') {
            $slug .= '.php';
        }

        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Plugin.php';
        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Skin/Plugin.php';

        if (!$path && strpos($slug, 'masterslider.php') !== false) {
            // prepare update of exceptional plugins
            AutoUpdater_Helper_Extension::loadMasterSliderPro();
        }

        $plugin_path = $this->getPluginPath($slug);
        if (!$plugin_path) {
            throw AutoUpdater_Exception_Response::getException(
                200,
                'Failed to update plugin: ' . $slug,
                'no_update_warning',
                'No update was performed, plugin directory not found'
            );
        }

        // Update slug as it may have changed
        $slug = plugin_basename($plugin_path);
        $data = get_file_data($plugin_path, array('Version' => 'Version'));
        $this->task->old_version = $data['Version'];

        $is_plugin_active_before_update = is_plugin_active($slug);

        if ($path) {
            $nonce = 'plugin-upload';
            $url = add_query_arg(array('package' => $path), 'update.php?action=upload-plugin');
            $type = 'upload'; //Install plugin type, From Web or an Upload.
        } else {
            $plugin = $slug;
            $nonce = 'upgrade-plugin_' . $plugin;
            $url = 'update.php?action=upgrade-plugin&plugin=' . rawurlencode($plugin);
            $type = 'plugin';
        }

        ob_start();

        $this->task->upgrader = new AutoUpdater_Upgrader_Plugin(
            new AutoUpdater_Upgrader_Skin_Plugin(
                @compact('nonce', 'url', 'plugin', 'type')
            )
        );

        add_filter('upgrader_package_options', array($this, 'onUpgradePackageOptions'), 10, 1);

        // don't clear update cache, so next plugin's update step in same action will be able to use update cache data
        $result = $path ? $this->task->upgrader->install($path, array('clear_update_cache' => false)) : $this->task->upgrader->upgrade($slug, array('clear_update_cache' => false));

        $output = ob_get_clean();
        if (!empty($output)) {
            AutoUpdater_Log::debug('Updater output: ' . $output);
        }

        // Get the plugin path again, as the plugin main file may have changed
        $plugin_path = $this->getPluginPath($slug);
        if ($plugin_path) {
            // Update slug as it may have changed
            $slug = plugin_basename($plugin_path);
            $data = get_file_data($plugin_path, array('Version' => 'Version'));
            $this->task->new_version = $data['Version'];
        }

        if ($is_plugin_active_before_update && !is_plugin_active($slug)) {
            $error = new WP_Error('deactivated', 'Plugin was deactivated after the update');
            /** @var AutoUpdater_Upgrader_Skin_Plugin $skin */
            $skin = $this->task->upgrader->skin;
            $skin->error($error);
        }

        return $result;
    }

    /**
     * @param string $slug
     *
     * @return string
     */
    protected function getPluginPath($slug)
    {
        $plugin_path = WP_PLUGIN_DIR . '/' . $slug;
        if (AutoUpdater_Filemanager::getInstance()->exists($plugin_path)) {
            return $plugin_path;
        }

        AutoUpdater_Log::error('Plugin directory not found: ' . $plugin_path);
        $slug = AutoUpdater_Helper_Extension::getPluginRealSlug($slug);
        if (!$slug) {
            return '';
        }

        AutoUpdater_Log::debug('Changing plugin slug to: ' . $slug);
        $plugin_path = WP_PLUGIN_DIR . '/' . $slug;

        return $plugin_path;
    }

    /**
     * @param array $options
     *
     * @link https://developer.wordpress.org/reference/hooks/upgrader_package_options/
     * @see WP_Upgrader::run()
     */
    public function onUpgradePackageOptions($options)
    {
        remove_filter('upgrader_pre_install', array($this->task->upgrader, 'deactivate_plugin_before_upgrade'));

        return $options;
    }

}
