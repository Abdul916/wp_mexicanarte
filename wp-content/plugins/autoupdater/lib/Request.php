<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Request
{
    /** @var int */
    public $timeout = 15;

    /** @var string */
    public $method = '';

    /** @var string */
    public $url = '';

    /** @var array */
    public $headers = array();

    /** @var array */
    public $query = array();

    /** @var string|array */
    public $data = '';

    /**
     * @param string       $method
     * @param string       $url
     * @param array        $query
     * @param array|string $data
     * @param array        $headers
     */
    public function __construct($method, $url, $query = array(), $data = '', $headers = array())
    {
        $this->method = strtoupper($method);
        $this->url = $url;
        $this->query = $query;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        $query = array();
        foreach ($this->query as $key => $value) {
            $query[] = $key . '=' . rawurlencode($value);
        }

        $url = $this->url;
        if (!empty($query)) {
            $url .= (strpos($url, '?') === false ? '?' : '&') . implode('&', $query);
        }

        return $url;
    }

    /**
     * @return AutoUpdater_Response
     */
    public function send()
    {
        $args = array(
            'method' => $this->method,
            'sslverify' => AutoUpdater_Config::get('ssl_verify', 0) ? true : false,
            'timeout' => $this->timeout,
        );

        if (!empty($this->headers)) {
            $args['headers'] = $this->headers;
        }

        if ($this->method !== 'GET') {
            if (
                isset($this->headers['Content-Type']) &&
                strpos($this->headers['Content-Type'], 'application/json') !== false &&
                !is_scalar($this->data)
            ) {
                $args['body'] = json_encode($this->data);
            } else {
                $args['body'] = $this->data;
            }
        }

        $url = $this->getUrl();

        AutoUpdater_Log::debug("Request {$this->method} $url with arguments " . print_r($args, true));
        $result = wp_remote_request($url, $args);

        return AutoUpdater_Response::getInstance()
            ->bind($result);
    }

    /**
     * @param string       $method
     * @param string       $endpoint
     * @param array        $query
     * @param array|string $data
     * @param int          $site_id
     *
     * @return AutoUpdater_Request
     *
     * @throws AutoUpdater_Exception_Response
     */
    public static function api($method = 'GET', $endpoint = '', $query = array(), $data = '', $site_id = 0)
    {
        $site_id = (int) ($site_id ? $site_id : AutoUpdater_Config::get('site_id'));
        if (!$site_id) {
            throw new AutoUpdater_Exception_Response('Missing required parameters', 400);
        }

        $method = strtoupper($method);
        if (!in_array($method, array('GET', 'POST', 'PUT', 'PATCH'))) {
            throw new AutoUpdater_Exception_Response(sprintf('Invalid request method: %s', $method), 400);
        }

        $headers = array(
            'wpe-site-id' => $site_id,
            'wpe-nonce' => time(),
        );

        if (substr($endpoint, -4) !== '.zip') {
            $headers['Content-Type'] = 'application/json';
        }

        $signature = static::getApiRequestSignature($method, $query, $data, $headers);
        $headers['Authorization'] = "Signature $signature";

        $url = AutoUpdater_Config::getAutoUpdaterApiBaseUrl()
            . str_replace('{ID}', $site_id, trim($endpoint, '/'));

        return new AutoUpdater_Request($method, $url, $query, $data, $headers);
    }

    /**
     * @param string       $method
     * @param array        $query
     * @param array|string $data
     * @param array        $headers
     *
     * @return string
     */
    public static function getApiRequestSignature($method = 'GET', $query = array(), $data = '', $headers = array())
    {
        $payload = array();

        foreach ($query as $key => $value) {
            if (strpos($key, 'wpe_') === 0) {
                $payload[$key] = $value;
            }
        }

        foreach ($headers as $key => $value) {
            if (strpos($key, 'wpe-') === 0) {
                $payload[$key] = $value;
            }
        }

        ksort($payload);

        if ($method !== 'GET' && $data !== '' && $data !== null) {
            $payload['json'] = json_encode($data);
        }

        return AutoUpdater_Authentication::getInstance()->getSignature($payload);
    }

    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function getQueryVar($key, $default = null)
    {
        if (!array_key_exists($key, $_GET)) { // phpcs:ignore
            return $default;
        }

        return urldecode($_GET[$key]); // phpcs:ignore
    }

    /**
     * @return string
     */
    public static function getCurrentUrl()
    {
        if (empty($_SERVER['HTTP_HOST'])) {
            return '';
        }

        return 'http' . (is_ssl() ? 's' : '')
            . '://'
            // Not form input data
            . $_SERVER['HTTP_HOST'] // phpcs:ignore
            . (!empty($_SERVER['REQUEST_URI']) ?
            parse_url(
                filter_var(wp_unslash($_SERVER['REQUEST_URI']), FILTER_SANITIZE_URL),
                PHP_URL_PATH
            ) : '');
    }
}
