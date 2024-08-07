<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_DebugEnable extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        $debug = (bool) AutoUpdater_Config::get('debug');
        if (!$debug && AutoUpdater_Config::set('debug', 1)) {
            $debug = true;
        }

        return array(
            'success' => ($debug === true),
        );
    }
}
