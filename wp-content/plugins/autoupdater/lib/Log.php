<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Log
{
    protected static $instance = null;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        $class_name = AutoUpdater_Loader::loadClass('Log');

        static::$instance = new $class_name();

        return static::$instance;
    }

    /**
     * @param string $message
     */
    public static function info($message)
    {
        static::getInstance()->log('info', $message);
    }

    /**
     * @param string $message
     */
    public static function debug($message)
    {
        static::getInstance()->log('debug', $message);
    }

    /**
     * @param string $message
     */
    public static function error($message)
    {
        static::getInstance()->log('error', $message);
    }

    /**
     * @return string
     */
    public function getLogsPath()
    {
        return rtrim(WP_CONTENT_DIR, '/\\') . '/.logs/';
    }

    /**
     * @param string $date The date in format YYYY-MM-DD
     * @return string
     */
    public function getLogsFilePath($date = '')
    {
        if (!$date) {
            $date = date('Y-m-d');
        }
        return $this->getLogsPath() . 'autoupdater_' . $date . '.logs.php';
    }

    /**
     * @param string $level
     * @param string $message
     */
    public function log($level, $message)
    {
        if (!AutoUpdater_Config::get('debug') && $level != 'error') {
            return;
        }

        $path = $this->getLogsPath();
        $filemanager = AutoUpdater_Filemanager::getInstance();

        if (!$filemanager->is_dir($path)) {
            $filemanager->mkdir($path);
        }

        $file_path = $this->getLogsFilePath();
        if (!$filemanager->exists($file_path)) {
            $filemanager->put_contents($file_path, '<?php die(); ?>');
        }

        $level = strtoupper($level);
        $date = date('Y-m-d H:i:s');

        $filemanager->put_contents(
            $file_path,
            "\n[$date] $level $message",
            FILE_APPEND
        );

        if ($level == 'ERROR') {
            // Log AutoUpdater errors additionally to PHP error log file. Make sure it won't be displayed
            $display_errors = ini_set('display_errors', 0); // phpcs:ignore
            $error_reporting_level = error_reporting(E_ALL); // phpcs:ignore

            trigger_error(sprintf('[AutoUpdater] %s', str_replace("\n", ' ', $message)), E_USER_NOTICE); // phpcs:ignore

            // Restore previous settings of error reporting and displaying
            error_reporting($error_reporting_level); // phpcs:ignore
            if ($display_errors !== false) {
                ini_set('display_errors', $display_errors); // phpcs:ignore
            }
        }
    }

    public static function traceHooks()
    {
        if (!AutoUpdater_Config::get('trace_hooks', 0)) {
            return;
        }

        add_action('all', array(static::getInstance(), 'logHooks'), 99999, 99);
    }

    public function logHooks()
    {
        global $wp_filter;
        $hook_name = current_filter();

        $exclude_hooks = array('gettext', 'gettext_with_context');
        if (in_array($hook_name, $exclude_hooks)) {
            return;
        }

        if (!isset($wp_filter[$hook_name])) {
            return;
        }

        $this->logHookDetails($hook_name, $wp_filter[$hook_name]);
    }

    /**
     * @param string $hook_name
     * @param array|WP_Hook $hook_name
     */
    protected function logHookDetails($hook_name, $hook)
    {
        if ($hook instanceof WP_Hook) {
            $hook = $hook->callbacks;
        }
        ksort($hook);

        foreach ($hook as $priority => $functions) {
            foreach ($functions as $function) {
                $this->log('debug', sprintf(
                    'Running hook: %s with priority: %d. Calling: %s with arguments: %s',
                    $hook_name,
                    $priority,
                    $this->callbackToString($function['function']),
                    $function['accepted_args']
                ));
            }
        }
    }

    protected function callbackToString($callback)
    {
        if (is_string($callback)) {
            return $callback;
        }

        if (is_a($callback, 'Closure')) {
            $closure = new ReflectionFunction($callback);
            return 'closure from ' . $closure->getFileName() . ' ' . $closure->getStartLine();
        }

        if (is_object($callback)) {
            $class = new ReflectionClass($callback);
            $name  = $class->getName();
            if (0 === strpos($name, 'class@anonymous')) {
                return 'anonymous class from ' . $class->getFileName() . ' ' . $class->getStartLine();
            }

            return $name;
        }

        if (!is_array($callback) || !array_key_exists(0, $callback) || !array_key_exists(1, $callback)) {
            return var_export($callback, true);
        }

        if (is_string($callback[0])) {
            return $callback[0] . '::' . $callback[1];
        }

        if (is_object($callback[0])) {
            return get_class($callback[0]) . '->' . $callback[1];
        }
    }
}
