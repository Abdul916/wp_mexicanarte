<?php

defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_DatabaseUpdateElementor extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $success = false;
        $message = '';
        $plugin_slug = $this->input('slug');

        if (substr($plugin_slug, -4) !== '.php') {
            $plugin_slug .= '.php';
        }

        if ($plugin_slug != 'elementor-pro/elementor-pro.php' && $plugin_slug != 'elementor/elementor.php') {
            return array(
                'success' => true,
                'message' => 'Slug does not match either Elementor or Elementor Pro slugs'
            );
        }

        $plugin_dir = '/' . strtok($plugin_slug, '/');
        $plugin_name = 'Elementor' . (strpos($plugin_slug, 'pro') !== false ? ' Pro' : '');
        $plugin_file_name = strpos($plugin_slug, 'pro') !== 'false' ? ' elementor-pro.php' : 'elementor.php';


        if (!is_plugin_active($plugin_slug)) {
            return array(
                'success' => true,
                'message' => $plugin_name . ' plugin is not active, skipping database update'
            );
        }

        if (
            file_exists(WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name)
            && file_exists(WP_PLUGIN_DIR . $plugin_dir .  '/core/upgrade/manager.php')
        ) {
            include_once WP_PLUGIN_DIR . $plugin_dir . '/' . $plugin_file_name;
            include_once WP_PLUGIN_DIR . $plugin_dir . '/core/upgrade/manager.php';
        }

        $manager_class = '\Elementor\Core\Upgrade\Manager';

        if (!class_exists($manager_class)) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' =>  $plugin_name . ' plugin upgrade manager class not found, check for source code updates',
            );
        }

        $manager = new $manager_class();

        if (
            !method_exists($manager, 'should_upgrade')
            || !method_exists($manager, 'get_task_runner')
            || !method_exists($manager, 'get_upgrade_callbacks')
            || !method_exists($manager, 'on_runner_complete')
        ) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' =>  $plugin_name . ' plugin upgrade manager methods not found, check for source code updates',
            );
        }


        if (!$manager->should_upgrade()) {
            return array(
                'success' => true,
                'message' => 'The DB is already updated. Skipping...'
            );
        }

        try {
            $updater = $manager->get_task_runner();
            $callbacks = $manager->get_upgrade_callbacks();
            $did_tasks = false;
            if (!empty($callbacks)) {
                $updater->handle_immediately($callbacks);
                $did_tasks = true;
            }
            $manager->on_runner_complete($did_tasks);
            $success = true;
            $message = $plugin_name . ' plugin database upgraded successfully';
        } catch (Exception $err) {
            $message = $err->getMessage();
        }

        return array(
            'success' => $success,
            'message' => $message
        );
    }
}
