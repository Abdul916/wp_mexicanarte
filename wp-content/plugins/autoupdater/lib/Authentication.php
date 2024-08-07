<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Authentication
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

        $class_name = AutoUpdater_Loader::loadClass('Authentication');

        static::$instance = new $class_name();

        return static::$instance;
    }

    /**
     * @param array $payload
     * @param string $method
     *
     * @return bool
     *
     * @throws Exception
     */
    public function validate($payload, $method)
    {
        $timestamp = time();
        $lifetime = 90;
        $received_timestamp = array_key_exists('wpe_timestamp', $payload) ? $payload['wpe_timestamp'] : '';

        if (!$received_timestamp || $received_timestamp < $timestamp - $lifetime) {
            AutoUpdater_Log::error(sprintf('Invalid timestamp, actual %d, and expected not older than %ds but received "%s". Received %s request to %s', $timestamp, $lifetime, $received_timestamp, strtoupper($method), AutoUpdater_Request::getCurrentUrl()));
            $e = new Exception('Invalid timestamp', 403);
            $e->timestamp = $timestamp;
            throw $e;
        }

        $signature = $this->getSignature($payload);
        $received_signature = AutoUpdater_Request::getQueryVar('wpe_signature');
        if (
            !$signature || empty($received_signature) ||
            !hash_equals($received_signature, $signature) // phpcs:ignore PHPCompatibility.FunctionUse.NewFunctions
        ) {
            AutoUpdater_Log::error(sprintf('Invalid signature, expected "%s" but received "%s". Received %s request to %s', $signature, $received_signature, strtoupper($method), AutoUpdater_Request::getCurrentUrl()));
            AutoUpdater_Log::error(sprintf('Decoded request payload: %s', print_r($payload, true)));
            $e = new Exception('Invalid signature', 403);
            $e->signature = $signature;
            throw $e;
        }

        return true;
    }

    /**
     * @param array  $payload
     *
     * @return false|string
     */
    public function getSignature($payload = array())
    {
        $token = AutoUpdater_Config::get('worker_token');

        $message = '';
        foreach ($payload as $key => $value) {
            $message .= $key . $value;
        }

        AutoUpdater_Log::debug(sprintf('Generated message to sign with token: %s', $message));

        return hash_hmac('sha256', $message, $token);
    }

    /**
     * @return bool
     */
    public function logInAsAdmin()
    {
        require_once ABSPATH . 'wp-includes/pluggable.php';
        $users = get_users(array('role' => 'administrator', 'number' => 1));
        if (!empty($users[0]->ID)) {
            wp_set_current_user($users[0]->ID);
        }

        return is_user_logged_in();
    }
}

if (!function_exists('hash_equals')) {
    function hash_equals($str1, $str2)
    {
        if (strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for ($i = strlen($res) - 1; $i >= 0; $i--) {
                $ret |= ord($res[$i]);
            }

            return !$ret;
        }
    }
}
