<?php

defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ElementorFlushCss extends AutoUpdater_Task_Base
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
                'message' => 'Slug does not match either Elementor or Elementor Pro.'
            );
        }

        $plugin_dir = '/' . strtok($plugin_slug, '/');
        $plugin_name = 'Elementor' . (strpos($plugin_slug, 'pro') !== false ? ' Pro' : '');
        $plugin_file_name = strpos($plugin_slug, 'pro') !== 'false' ? ' elementor-pro.php' : 'elementor.php';

        if (!is_plugin_active($plugin_slug)) {
            return array(
                'success' => true,
                'message' => $plugin_name . ' plugin is not active, skipping flushing CSS'
            );
        }

        if (
            file_exists(WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name)
            && file_exists(WP_PLUGIN_DIR . $plugin_dir .  '/core/files/manager.php')

        ) {
            include_once WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name;
            include_once WP_PLUGIN_DIR . $plugin_dir . '/core/files/manager.php';
        }

        $manager_class = '\Elementor\Core\Files\Manager';

        if (!class_exists($manager_class)) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' =>  $plugin_name . ' plugin files manager class not found, check for source code update',
            );
        }

        $manager = new $manager_class();

        if (
            !method_exists($manager, 'clear_cache')
        ) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' =>  $plugin_name . ' plugin file manager method: clear_cache  not found, check for source code updates',
            );
        }

        $network = !empty($assoc_args['network']) && is_multisite();
        if ($network) {
            $blogs = get_sites();
            foreach($blogs as $keys => $blog) {
                switch_to_blog($blog_id);
                $manager->clear_cache();
                restore_current_blog();
            }
        } else {
            $manager->clear_cache();
        }

        return array(
            'success' => true,
	        'message' => 'Elementor CSS cached flushed'
        );
    }
}
