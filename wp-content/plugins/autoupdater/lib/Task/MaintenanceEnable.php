<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_MaintenanceEnable extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        $maintenance_enabled = AutoUpdater_Maintenance::getInstance()->enable();

        return array(
            'success' => $maintenance_enabled,
            'is_offline' => $maintenance_enabled,
        );
    }
}
