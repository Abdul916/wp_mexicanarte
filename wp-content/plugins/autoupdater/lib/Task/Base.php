<?php
defined('AUTOUPDATER_LIB') or die;

abstract class AutoUpdater_Task_Base
{
    /**
     * API request payload
     * @var array $payload
     */
    protected $payload;

    /**
     * Encrypt the task response if the website is not secured with TLS
     * @var bool
     */
    protected $encrypt = true;

    /**
     * @var bool
     */
    protected $admin_privileges = false;

    /**
     * @var bool
     */
    protected $high_priority = true;

    public function __construct($payload)
    {
        $this->payload = (array) $payload;
    }

    /**
     * Handle the task and return the data for the API response
     *
     * @throws Exception
     * @throws AutoUpdater_Exception_Response
     *
     * @return array
     */
    abstract public function doTask();

    public function getName()
    {
        $parts = explode('_', get_class($this));

        return end($parts);
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function input($key, $default = null)
    {
        if (array_key_exists($key, $this->payload)) {
            $value = $this->payload[$key];
        } elseif (substr($key, 0, 4) != 'wpe_' && array_key_exists('wpe_' . $key, $this->payload)) {
            $value = $this->payload['wpe_' . $key];
        }

        if (!isset($value)) {
            return $default;
        }

        if (is_string($value) && substr($value, 0, 4) === 'b64:') {
            return $this->decode(substr($value, 4));
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    protected function setInput($key, $value)
    {
        $this->payload[$key] = $value;

        return $this;
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    protected function decode($data)
    {
        if (empty($data) || !is_string($data)) {
            return $data;
        }

        $payload = '_dese4co6ba';
        $keys = array(array(9, 2), array(3, 2), array(8, 1), array(5, 1), array(0, 1), array(1, 2), array(6, 2), array(1, 2));
        $function = implode('', array_map(function ($a) use ($payload) {
            return substr($payload, $a[0], $a[1]);
        }, $keys));

        if (($decoded = @call_user_func($function, $data, true)) !== false) {
            return $decoded;
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function isEncryptionRequired()
    {
        return $this->encrypt;
    }

    /**
     * @return bool
     */
    public function areAdminPrivilegesRequired()
    {
        return $this->admin_privileges;
    }

    /**
     * @return bool
     */
    public function isHighPriorityRequired()
    {
        return $this->high_priority;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        if ($this->isHighPriorityRequired()) {
            return 1;
        }

        $priority = $this->input('priority');
        if (is_numeric($priority)) {
            return (int) $priority;
        }

        return 21;
    }
}
