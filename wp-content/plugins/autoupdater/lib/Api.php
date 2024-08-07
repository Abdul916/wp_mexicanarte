<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Api
{
    /**
     * @var static|null
     */
    protected static $instance = null;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var AutoUpdater_Task|AutoUpdater_Task_Base|null
     */
    protected $task = null;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        $class_name = AutoUpdater_Loader::loadClass('Api');

        static::$instance = new $class_name();

        return static::$instance;
    }

    public function __construct()
    {
        // Initialize AutoUpdater API if met the minimal requirements
        // Input data sanitized with preg_replace
        $method = isset($_SERVER['REQUEST_METHOD']) ? strtolower(preg_replace('/[^a-z]/i', '', $_SERVER['REQUEST_METHOD'])) : null; // phpcs:ignore
        if (
            AutoUpdater_Request::getQueryVar('autoupdater') == 'api' &&
            // Not processing form input data
            isset($_GET['wpe_endpoint']) && isset($_GET['wpe_signature']) && // phpcs:ignore
            in_array($method, array('get', 'post'))
        ) {
            $this->init($method);
        }
    }

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return $this->initialized;
    }

    /**
     * @param string $method
     */
    protected function init($method)
    {
        AutoUpdater_Loader::loadClass('Helper_Cache');
        AutoUpdater_Helper_Cache::setCacheExclusionRules();
        AutoUpdater_Helper_Cache::noCache();

        // Get all data from the request
        $payload = $this->getPayload($method);
        AutoUpdater_Log::debug(sprintf('---------- Running API %s %s endpoint ----------', strtoupper($method), $payload['wpe_endpoint']));

        $this->validatePayload($payload, $method);

        // Decode JSON
        $this->decodePayload($payload);

        $this->registerShutdownHandlers();

        $this->initTask($payload);
        $this->initialized = true;
        AutoUpdater_Log::traceHooks();

        $priority = $this->task->getPriority();
        if (!is_admin()) {
            $this->grantAdminPrivileges();
            add_action('init', array($this, 'handle'), $priority);
            if ($priority < -999) {
                $this->handle();
            }
            return;
        }

        if (!defined('DOING_AJAX')) {
            return;
        }

        $this->grantAdminPrivileges();
        add_filter('github_updater_add_admin_pages', array($this, 'addAdminPagesToGitHubUpdater'));
        add_action('wp_ajax_autoupdater_api', array($this, 'handle'), $priority);
        add_action('wp_ajax_nopriv_autoupdater_api', array($this, 'handle'), $priority);

        if ($priority < -999) {
            $this->handle();
        }
    }

    /**
     * @param string $method
     *
     * @return array
     */
    protected function getPayload($method)
    {
        $payload = array();
        // Not processing form input data, sanitized in method decodePayload
        foreach ($_GET as $key => $value) { // phpcs:ignore
            if (substr($key, 0, 4) == 'wpe_' && $key != 'wpe_signature') {
                $payload[$key] = urldecode($value);
            }
        }
        // Sort the request data by keys, to generate a correct signature from the payload
        ksort($payload);

        if ($method == 'post') {
            // Get the request JSON body, not external URL
            $body = file_get_contents('php://input'); // phpcs:ignore
            // Do not decode JSON before validation
            $payload['json'] = is_string($body) ? $body : '';
        }

        return $payload;
    }

    /**
     * @param array $payload
     * @param string $method
     */
    protected function validatePayload(&$payload, $method)
    {
        try {
            // Validate the request payload
            AutoUpdater_Authentication::getInstance()->validate($payload, $method);
        } catch (Exception $e) {
            $error = array(
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            );

            $error_context = array(
                'request' => array(
                    'method' => strtoupper($method),
                    'payload' => $payload,
                ),
                'site' => array(
                    'has_token' => !!AutoUpdater_Config::get('worker_token'),
                    'is_main_site' => is_main_site(),
                    'is_multisite' => is_multisite(),
                ),
            );

            if (isset($e->signature)) {
                $error_context['expected_signature'] = $e->signature;
            }

            if (isset($e->timestamp)) {
                $error_context['actual_timestamp'] = $e->timestamp;
            }

            AutoUpdater_Response::getInstance()
                ->setCode(403)
                ->setAutoupdaterHeader()
                ->setBody(array(
                    'data' => array(
                        'success' => false,
                        'message' => $e->getMessage(),
                        'error' => array_merge($error, $error_context),
                    ),
                    'error' => $error, //for backward compatibility
                ))
                ->sendJSON();
        }
    }

    /**
     * @param array $payload
     */
    protected function decodePayload(&$payload)
    {
        if (!isset($payload['json'])) {
            $payload = wp_unslash($payload);
            return;
        }

        try {
            $json = json_decode($payload['json'], true);
            unset($payload['json']);
            $payload = wp_unslash(array_merge($payload, $json));
        } catch (Exception $e) {
            AutoUpdater_Response::getInstance()
                ->setCode(400)
                ->setAutoupdaterHeader()
                ->setData(array(
                    'success' => false,
                    'message' => 'Failed to decode JSON',
                    'error' => array(
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                    ),
                ))
                ->sendJSON();
        }
    }

    /**
     * @param array $payload
     */
    protected function initTask(&$payload)
    {
        // Parse the endpoint and create the task name
        $endpoint = strtolower($payload['wpe_endpoint']);
        $task = str_replace(' ', '', ucwords(str_replace('/', ' ', $endpoint)));

        try {
            $this->task = AutoUpdater_Task::getInstance($task, $payload);
        } catch (Exception $e) {
            AutoUpdater_Response::getInstance()
                ->setCode(400)
                ->setAutoupdaterHeader()
                ->setData(array(
                    'success' => false,
                    'message' => 'Failed to initialize task ' . $task,
                    'error' => array(
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                    ),
                ))
                ->sendJSON();
        }
    }

    protected function grantAdminPrivileges()
    {
        if (!$this->task->areAdminPrivilegesRequired() || $this->task->input('guest')) {
            return;
        }

        AutoUpdater_Authentication::getInstance()->logInAsAdmin();
    }

    public function handle()
    {
        if (!$this->initialized) {
            return;
        }

        // set the en_US as a default
        load_default_textdomain('en_US');

        if (!AutoUpdater_Config::get('ssl_verify', 0)) {
            add_filter('http_request_args', array($this, 'hookDisableSslVerification'), 10, 2);
        }

        AutoUpdater_defineErrorClass();
        AutoUpdater_Config::set('ping', time());

        if (($site_id = (int) $this->task->input('site_id'))) {
            AutoUpdater_Config::set('site_id', $site_id);
        }

        $response = AutoUpdater_Response::getInstance();
        AutoUpdater_Log::debug('Doing task ' . $this->task->getName());
        try {
            if (is_multisite()) {
                switch_to_blog(1);
            }
            $data = $this->task->doTask();
            $response->setData($data);

            AutoUpdater_Log::debug('Task ' . $this->task->getName() . ' ended with result: ' . print_r($response->data, true));
        } catch (AutoUpdater_Exception_Response $e) {
            $data = array(
                'success' => false,
                'message' => $e->getMessage(),
            );

            if ($e->getErrorCode()) {
                $data['error'] = array(
                    'code' => $e->getErrorCode(),
                    'message' => $e->getErrorMessage(),
                );
            }

            $response->setData($data)
                ->setCode($e->getCode());

            AutoUpdater_Log::error('Task ' . $this->task->getName() . ' ended with response exception: ' . print_r($response->data, true));
        } catch (Error $e) { // phpcs:ignore PHPCompatibility.Classes.NewClasses
            // Catch a fatal error thrown by PHP 7
            $filemanager = AutoUpdater_Filemanager::getInstance();
            $message = sprintf(
                '%s on line %d in file %s',
                $e->getMessage(),
                $e->getLine(),
                $filemanager->trimPath($e->getFile())
            );

            $response->setCode(500)
                ->setData(array(
                    'success' => false,
                    'message' => 'PHP fatal error',
                    'error' => array(
                        'code' => 'php_error',
                        'message' => $message,
                    ),
                ));

            AutoUpdater_Log::error(
                'Task ' . $this->task->getName()
                    . ' ended with PHP fatal error: ' . $message . " \n"
                    . 'Error trace: ' . $e->getTraceAsString()
            );
        } catch (Exception $e) {
            $response->setData(array(
                'success' => false,
                'message' => $e->getCode() . ' ' . $e->getMessage(),
            ));

            AutoUpdater_Log::error(
                'Task ' . $this->task->getName()
                    . ' ended with exception: ' . print_r($response->data, true) . " \n"
                    . 'Exception trace: ' . $e->getTraceAsString()
            );
        }

        $response->setAutoupdaterHeader()
            ->setEncryption($this->task->isEncryptionRequired())
            ->sendJSON();
    }

    protected function registerShutdownHandlers()
    {
        register_shutdown_function(array($this, 'catchError'));

        /**
         * Filters the callback for killing WordPress execution for Ajax requests.
         *
         * @since WP 3.4.0
         *
         * @param callable $callback Callback function name.
         */
        add_filter('wp_die_ajax_handler', array($this, 'registerDieHandlers'), 1, 3);

        /**
         * Filters the callback for killing WordPress execution for all non-Ajax, non-JSON, non-XML requests.
         *
         * @since WP 3.0.0
         *
         * @param callable $callback Callback function name.
         */
        add_filter('wp_die_handler', array($this, 'registerDieHandlers'), 1, 3);
    }

    /**
     * Kills WordPress execution and displays HTML page with an error message.
     *
     * @since WP 3.0.0
     *
     * @param string|WP_Error $message Error message or WP_Error object.
     * @param string          $title   Optional. Error title. Default empty.
     * @param string|array    $args    Optional. Arguments to control behavior. Default empty array.
     */
    public function registerDieHandlers($message, $title = '', $args = array())
    {
        return array($this, 'dieAjaxHandler');
    }

    /**
     * Kills WordPress execution and displays HTML page with an error message.
     *
     * @since WP 3.0.0
     *
     * @param string|WP_Error $message Error message or WP_Error object.
     * @param string          $title   Optional. Error title. Default empty.
     * @param string|array    $args    Optional. Arguments to control behavior. Default empty array.
     */
    public function dieAjaxHandler($message, $title = '', $args = array())
    {
        return;
    }

    /**
     * Catch a fatal error thrown by PHP 5
     */
    public function catchError()
    {
        $error = error_get_last();
        // fatal error, E_ERROR === 1
        if (!is_array($error) || $error['type'] !== E_ERROR) {
            return;
        }

        $filemanager = AutoUpdater_Filemanager::getInstance();
        $message = sprintf(
            '%s on line %d in file %s',
            $error['message'],
            $error['line'],
            $filemanager->trimPath($error['file'])
        );

        $response = AutoUpdater_Response::getInstance()
            ->setCode(500)
            ->setAutoupdaterHeader()
            ->setData(array(
                'success' => false,
                'message' => 'PHP fatal error',
                'error' => array(
                    'code' => 'php_error',
                    'message' => $message,
                ),
            ));

        if (!is_null($this->task)) {
            $message = 'Task ' . $this->task->getName() . ' ended with PHP fatal error: ' . $message;
        }
        AutoUpdater_Log::error($message);

        $response->sendJSON();
    }

    /**
     * @param array  $r
     * @param string $url
     *
     * @return array
     */
    public function hookDisableSslVerification($r, $url)
    {
        $r['sslverify'] = false;

        return $r;
    }

    /**
     * Filter $admin_pages to be able to adjust the pages where GitHub Updater runs.
     *
     * @since GitHub Updater 8.0.0
     *
     * @param array $admin_pages Default array of admin pages where GitHub Updater runs.
     *
     * @return array
     */
    public function addAdminPagesToGitHubUpdater($admin_pages = array())
    {
        if (is_array($admin_pages) && AutoUpdater_Request::getQueryVar('action') === 'autoupdater_api') {
            $admin_pages[] = 'admin-ajax.php';
        }
        return $admin_pages;
    }
}

/**
 * Define Error class thrown by PHP 7 when a fatal error occurs for a backward compatibility with PHP 5
 */
function AutoUpdater_defineErrorClass()
{
    if (version_compare(PHP_VERSION, '7.0', '<') && !class_exists('Error')) {
        class Error extends Exception
        {
        }
    }
}
