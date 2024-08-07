<?php

defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ElementorLibrarySync extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $plugin_slug = $this->input('slug');

        if (substr($plugin_slug, -4) !== '.php') {
            $plugin_slug .= '.php';
        }

        if ($plugin_slug != 'elementor-pro/elementor-pro.php' && $plugin_slug != 'elementor/elementor.php') {
            return array(
                'success' => true,
                'message' => 'Slug does not match either Elementor or Elementor Pro'
            );
        }

        $plugin_dir = '/' . strtok($plugin_slug, '/');
        $plugin_name = 'Elementor' . (strpos($plugin_slug, 'pro') !== false ? ' Pro' : '');
        $plugin_file_name = strpos($plugin_slug, 'pro') !== 'false' ? ' elementor-pro.php' : 'elementor.php';

        if (!is_plugin_active($plugin_slug)) {
            return array(
                'success' => true,
                'message' => $plugin_name . ' plugin is not active, skipping library sync'
            );
        }

        if (
            file_exists(WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name)
           && file_exists(WP_PLUGIN_DIR . $plugin_dir . '/includes/api.php')
        ) {
            include_once WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name;
            include_once WP_PLUGIN_DIR . $plugin_dir . '/includes/api.php';
        }

        $api_class = '\Elementor\Api';

        if (!class_exists($api_class)) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' =>  $plugin_name . ' api class not found, check for source code update',
            );
        }

        $api = new $api_class();

        if (!method_exists($api_class, 'get_library_data')) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => $plugin_name . ' api method: get_library_data not found, check for source code update',
            );
        }

        $data = $api->get_library_data(true);
        if (empty($data)) {
            return array(
                'success' => false,
                'message' =>  'Cannot sync library',
            );
        }

        return array(
            'success' => true,
            'message' => 'Library has been synced'
        );
    }
}
