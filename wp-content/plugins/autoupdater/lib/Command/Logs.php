<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Logs extends AutoUpdater_Command_Base
{
    /**
     * Gets logs with errors saved on AutoUpdater WordPress plugin side
     *
     * By default displays today's logs or specified with --date parameter.
     * Logs are stored in PHP files with autoupdater prefix in wp-content/.logs/ directory.
     * To save more logs, turn on debug mode by running: wp autoupdater settings set --debug-response=true
     *
     * ## OPTIONS
     *
     * [--date=<YYYY-MM-DD>]
     * : Get logs from a given date. All times are UTC. Defaults to the current date.
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        $data = array();
        if (!empty($assoc_args['date'])) {
            if (!$this->isDate($assoc_args['date'])) {
                WP_CLI::error('Invalid date format. Use YYYY-MM-DD format.');
            }
            $data['date'] = $assoc_args['date'];
        }

        /** @var AutoUpdater_Task_DebugLogs $task */
        $task = AutoUpdater_Task::getInstance('DebugLogs', $data);

        try {
            $result = $task->doTask();
        } catch (Exception $e) {
            WP_CLI::error($e->getMessage());
            return;
        }

        WP_CLI::line($result['logs']);
    }

    public static function beforeInvoke()
    {
    }
}
