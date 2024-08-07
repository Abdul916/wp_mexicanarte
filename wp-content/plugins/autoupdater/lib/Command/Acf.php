<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Acf extends AutoUpdater_Command_Base
{
    /**
     * Commands for Advanced Custom Fields
     *
     * ## OPTIONS
     *
     * <command>
     * : Specify the sub-command.
     * ---
     * default: upgrade
     * options:
     *   - upgrade
     *
     * [--plugin_slug=<slug>]
     * : Plugin slug.
     * ---
     * default: advanced-custom-fields/acf.php
     * options:
     *   - advanced-custom-fields/acf.php
     *   - advanced-custom-fields-pro/acf.php
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        if (empty($args)) {
            $args[0] = 'upgrade';
        }

        if ($args[0] == 'upgrade') {
            $this->acfUpgrade($assoc_args);
            return;
        }
    }

    /**
     * @param array $assoc_args
     */
    protected function acfUpgrade($assoc_args)
    {
        WP_CLI::line('Upgrading ACF...');

        /** @var AutoUpdater_Task_DatabaseUpdateAcf $task */
        $task = AutoUpdater_Task::getInstance('DatabaseUpdateAcf', array('slug' => $assoc_args['plugin_slug']));
        $result = $task->doTask();

        if ($result['success'] === false) {
            // Failed to upgrade ACF
            WP_CLI::error($result['message']);
            return;
        }

        // ACF has been successfully upgraded
        WP_CLI::success($result['message']);
    }

    public static function beforeInvoke()
    {
    }
}
