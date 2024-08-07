<?php
defined('AUTOUPDATER_LIB') or die;

require_once AUTOUPDATER_LIB_PATH . 'Task/Base.php';

class AutoUpdater_Task
{
    protected static $instances = array();

    /**
     * @param string     $task
     * @param array|null $payload
     *
     * @return AutoUpdater_Task_Base
     * @throws Exception
     */
    public static function getInstance($task, $payload = null)
    {
        if (isset(static::$instances[$task])) {
            return static::$instances[$task];
        }

        $class_name = AutoUpdater_Loader::loadClass('Task_' . $task);
        if (!$class_name) {
            throw new Exception('Unknown task');
        }

        static::$instances[$task] = new $class_name($payload);

        return static::$instances[$task];
    }
}
