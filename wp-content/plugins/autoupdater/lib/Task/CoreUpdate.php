<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_CoreUpdate extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $this->setInput('type', 'core');
        $this->setInput('slug', 'wordpress');

        /** @see AutoUpdater_Task_ExtensionUpdate::doTask() */
        return AutoUpdater_Task::getInstance('ExtensionUpdate', $this->payload)
            ->doTask();
    }
}
