<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ExtensionDisable extends AutoUpdater_Task_Base
{
    protected $high_priority = false;

    /**
     * @return array
     */
    public function doTask()
    {
        $plugins = array();

        $slug = $this->input('slug');
        if ($slug) {
            if (substr($slug, -4) !== '.php') {
                $slug .= '.php';
            }
            $plugins[] = $slug;
        }

        $extensions = (array) $this->input('extensions', array());
        foreach ($extensions as $extension) {
            if (empty($extension['slug'])) {
                continue;
            }
            $plugins[] = $extension['slug'];
        }

        // Skip AutoUpdater extension
        if (($key = array_search(AUTOUPDATER_WP_PLUGIN_SLUG, $plugins)) !== false) {
            unset($plugins[$key]);
        }

        if (empty($plugins)) {
            throw new AutoUpdater_Exception_Response('No extensions to deactivate', 400);
        }

        AutoUpdater_Loader::loadClass('Helper_Extension');
        $filemanager = AutoUpdater_Filemanager::getInstance();
        // Find a real path to plugins as the input might be lower-case while the directory name uses capital letters too
        foreach ($plugins as &$plugin) {
            if ($filemanager->exists(WP_PLUGIN_DIR . '/' . $plugin)) {
                continue;
            }
            $new_plugin = AutoUpdater_Helper_Extension::getPluginRealSlug($plugin);
            if ($new_plugin && $filemanager->exists(WP_PLUGIN_DIR . '/' . $new_plugin)) {
                $plugin = $new_plugin;
            }
        }

        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins($plugins, true);

        return array(
            'success' => true,
        );
    }
}
