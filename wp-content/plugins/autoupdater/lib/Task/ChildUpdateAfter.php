<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ChildUpdateAfter extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        if (!AutoUpdater_Installer::getInstance()->update()) {
            return array(
                'success' => false,
                'message' => 'Failed to finish update',
            );
        }

        return array(
            'success' => true,
        );
    }
}
