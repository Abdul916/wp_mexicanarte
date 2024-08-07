<?php
defined('AUTOUPDATER_LIB') or die;

abstract class AutoUpdater_Upgrader_Task_Base
{
    /** @var AutoUpdater_Task_ExtensionUpdate */
    protected $task;

    /**
     * @param AutoUpdater_Task_ExtensionUpdate $task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * @param string $slug
     * @param string $path
     *
     * @return mixed
     * @throws
     */
    abstract public function update($slug, $path = '');
}
