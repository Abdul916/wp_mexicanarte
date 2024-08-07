<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Version extends AutoUpdater_Command_Base
{
    /**
     * Gets AutoUpdater WordPress plugin version
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        WP_CLI::line(sprintf('%s %s', AUTOUPDATER_WP_PLUGIN_NAME, AUTOUPDATER_VERSION));
    }

    public static function beforeInvoke()
    {
    }
}
