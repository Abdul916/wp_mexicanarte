<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_MaintenanceDisable extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        if (!AutoUpdater_Maintenance::getInstance()->isEnabled()) {
            $maintenance_disabled = true;
            $was_maintenance_enabled = false;
        } else {
            $maintenance_disabled = AutoUpdater_Maintenance::getInstance()->disable();
            $was_maintenance_enabled = true;
        }

        return array(
            'success' => $maintenance_disabled,
            'is_offline' => !$maintenance_disabled,
            'was_offline' => $was_maintenance_enabled,
        );
    }
}
