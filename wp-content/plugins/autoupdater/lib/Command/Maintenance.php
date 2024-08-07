<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Maintenance extends AutoUpdater_Command_Base
{
    /**
     * Display maintenance mode status or turn it off
     *
     * ## OPTIONS
     *
     * [<action>]
     * : .
     * default: status
     * options:
     *   - status
     *   - off
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        if (empty($args) || $args[0] === 'status') {
            $this->displayStatus();
            return;
        }

        if ($args[0] === 'off') {
            $this->turnOff();
            return;
        }
    }

    protected function displayStatus()
    {
        $maintenance = AutoUpdater_Maintenance::getInstance();
        if (!$maintenance->isEnabled()) {
            WP_CLI::log('Maintenance mode is turned off.');
            return;
        }

        list($started_at, $running_for) = $this->getMaintenanceTiming();
        WP_CLI::log(sprintf('Maintenance mode was started at %s and is running for %s.', $started_at, $running_for));
        return;
    }

    protected function turnOff()
    {
        $maintenance = AutoUpdater_Maintenance::getInstance();
        if (!$maintenance->isEnabled()) {
            WP_CLI::success('Maintenance mode is turned off already.');
            return;
        }

        list($started_at, $running_for) = $this->getMaintenanceTiming();
        if ($maintenance->disable()) {
            WP_CLI::success(sprintf('Maintenance mode has been turned off. It was started at %s and was running for %s.', $started_at, $running_for));
            return;
        }

        WP_CLI::error(sprintf('Failed to turn off maintenance mode! It was started at %s and is running for %s.', $started_at, $running_for));
        return;
    }

    /**
     * @return array
     */
    protected function getMaintenanceTiming()
    {
        $maintenance = AutoUpdater_Maintenance::getInstance();
        $started_at = $maintenance->enabledAt();
        if (!$started_at) {
            $started_at = 'an unknown date';
            $running_for = 'an unknown time period';
        } else {
            $running_for = $maintenance->howLongIsEnabled();
        }

        return array($started_at, $running_for);
    }

    public static function beforeInvoke()
    {
    }
}
