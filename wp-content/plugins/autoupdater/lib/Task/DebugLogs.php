<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_DebugLogs extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        $date = preg_replace('/[^0-9-]/', '', $this->input('date', date('Y-m-d')));
        $path = AutoUpdater_Log::getInstance()->getLogsFilePath($date);

        $filemanager = AutoUpdater_Filemanager::getInstance();
        if (!$filemanager->is_file($path)) {
            throw new AutoUpdater_Exception_Response('Logs file with date: ' . $date . ' was not found', 404);
        }

        return array(
            'success' => true,
            'logs' => $filemanager->get_contents($path),
        );
    }
}
