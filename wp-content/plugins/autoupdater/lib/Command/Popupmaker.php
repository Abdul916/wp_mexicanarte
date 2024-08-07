<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Popupmaker extends AutoUpdater_Command_Base
{
    /**
     * Commands for Popup Maker
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
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        if (empty($args)) {
            $args[0] = 'upgrade';
        }

        if ($args[0] == 'upgrade') {
            $this->pumUpgrade();
            return;
        }
    }

    protected function pumUpgrade()
    {
        WP_CLI::line('Upgrading Popup Maker...');

        /** @var AutoUpdater_Task_DatabaseUpdatePum $task */
        $task = AutoUpdater_Task::getInstance('DatabaseUpdatePum');
        $result = $task->doTask();

        if ($result['success'] === false) {
            // Failed to upgrade PUM
            WP_CLI::error($result['message']);
            return;
        }

        // PUM has been successfully upgraded
        WP_CLI::success($result['message']);
    }

    public static function beforeInvoke()
    {
    }
}
