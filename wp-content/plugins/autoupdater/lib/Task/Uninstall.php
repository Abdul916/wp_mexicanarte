<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_Uninstall extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $result = AutoUpdater_Installer::getInstance()
            ->uninstall(true);

        return array(
            'success' => $result,
        );
    }
}
