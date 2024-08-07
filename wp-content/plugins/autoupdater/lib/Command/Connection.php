<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Connection extends AutoUpdater_Command_Base
{
    /**
     * Gets a signed URL to AutoUpdater WordPress plugin API valid for 5 minutes to test the connection
     *
     * ## OPTIONS
     *
     * [--frontend]
     * : Outputs URL to the website's front-end instead of wp-admin
     *
     * [--endpoint=<endpoint>]
     * : Request endpoint. Use only if you know how to use it.
     *
     * [--priority=<integer>]
     * : WordPress code execution priority. The lower number, the higher priority:
     *   - 11 Low priority
     *   - 10 WordPress's default
     *   - 1 High priority
     *   - -1000 Highest possible priority
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        $endpoint = !empty($assoc_args['endpoint']) ? $assoc_args['endpoint'] : 'child/verify';
        $priority = array_key_exists('priority', $assoc_args) ? (int) $assoc_args['priority'] : null;
        $frontend = isset($assoc_args['frontend']);

        WP_CLI::line('Run the following command to test the connection with the AutoUpdater WordPress plugin API.');
        if ($priority <= -1000) {
            WP_CLI::line('If you will not get a successful JSON response then generate and test a new URL with --priority=-1000 parameter');
        }
        WP_CLI::line("\n" . sprintf('curl -iL -H "Accept: application/json" -H "autoupdater-connector: 2.0" "%s"', $this->getWorkerPluginApiUrl($endpoint, $frontend, $priority)));
    }

    /**
     * @param string $endpoint
     * @param bool $frontend
     * @param int|null $priority
     */
    protected function getWorkerPluginApiUrl($endpoint = 'child/verify', $frontend = false, $priority = null)
    {
        $method = 'GET';
        $query = array(
            'wpe_timestamp' => time() + (5 * 60),
            'wpe_endpoint' => $endpoint,
        );

        if (is_int($priority)) {
            $query['wpe_priority'] = $priority;
        }

        $query['wpe_signature'] = AutoUpdater_Request::getApiRequestSignature($method, $query);

        foreach ($query as $key => $value) {
            $query[$key] = $key . '=' . rawurlencode($value);
        }
        $query = implode('&', $query);

        if ($frontend) {
            return site_url('?autoupdater=api') . '&' . $query;
        }

        return admin_url('admin-ajax.php?action=autoupdater_api&autoupdater=api') . '&' . $query;
    }

    public static function beforeInvoke()
    {
    }
}
