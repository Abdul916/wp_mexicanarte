<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_CoreUpdateAfter extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        wp_upgrade();

        return array(
            'success' => true,
        );
    }
}
