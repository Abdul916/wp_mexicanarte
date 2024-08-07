<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Settings extends AutoUpdater_Command_Base
{
    protected $bool_options = array(
        'autoupdater-enabled',
        'update-plugins',
        'update-themes',
        'notification-on-success',
        'notification-on-failure',
        'auto-rollback',
        'maintenance-mode',
        'encrypt-response',
        'debug-response',
        'trace-hooks',
    );

    protected $int_options = array(
        'autoupdate-at',
        'site-id',
        'vrt-urls-limit',
    );

    protected $string_options = array(
        'frontend-url',
        'backend-url',
        'sitemap-url',
        'vrt-css-exclusions',
    );

    protected $array_options = array(
        'notification-emails',
        'excluded-plugins',
        'excluded-themes',
    );

    protected $api_options = array(
        'frontend-url',
        'backend-url',
        'autoupdater-enabled',
        'autoupdate-at',
        'autoupdate-days',
        'autoupdate-frequency',
        'autoupdate-scheduled-at',
        'update-plugins',
        'update-themes',
        'plugins',
        'themes',
        'notification-emails',
        'notification-on-success',
        'notification-on-failure',
        'auto-rollback',
        'maintenance-mode',
        'sitemap-url',
        'vrt-css-exclusions',
        'vrt-urls-limit',
        'worker-token',
        'aes-key',
    );

    protected $local_options = array(
        'worker-token',
        'aes-key',
        'site-id',
        'encrypt-response',
        'debug-response',
        'trace-hooks',
    );

    /**
     * Display or update AutoUpdater settings
     *
     * ## OPTIONS
     *
     * <action>
     * : get or set AutoUpdater settings
     * ---
     * default: get
     * options:
     *   - get
     *   - set
     *
     * [--autoupdater-enabled=<bool>]
     * : Enable automatic updates.
     *
     * [--excluded-plugins=<string>]
     * : A list of all excluded plugins, separated with a comma (,). Example value: akismet,wordpress-seo. Every plugin not provided within the option will be enabled for updates.
     *
     * [--excluded-themes=<string>]
     * : A list of all excluded themes, separated with a comma (,). Example value: twentytwelve,twentynineteen. Every theme not provided within the option will be enabled for updates.
     *
     * [--notification-emails=<emails>]
     * : E-mail addresses separated with a comma (,) which receive a notification after an automatic update of this website.
     *
     * [--notification-on-success=<bool>]
     * : Receive notifications after successful updates.
     *
     * [--notification-on-failure=<bool>]
     * : Receive notifications after failed updates.
     *
     * [--auto-rollback=<bool>]
     * : Enable automatic rollback after failed updates.
     *
     * [--maintenance-mode=<bool>]
     * : Put the website in a maintenance mode during an update in order to prevent data loss.
     *
     * [--frontend-url=<url>]
     * : The URL to this website's home page.
     *
     * [--backend-url=<url>]
     * : The URL to this website's WP Admin.
     *
     * [--sitemap-url=<url>]
     * : The URL to this website's sitemap to test up to 20 random URLs during an update. Accepted formats: XML <urlset> and <sitemapindex> or a plain text sitemap with an absolute URL on each line. Put a line break after the last URL.
     *
     * [--vrt-css-exclusions=<string>]
     * : Hide elements matching the CSS selectors, separated with a comma (,) during visual regression testing. It’s recommended to exclude dynamic content which might lead to false negatives, such as sliders, ads or testimonials.
     *
     * [--vrt-urls-limit=<int>]
     * : The limit of URLs between 0 and 20 from website's sitemap to test during an update.
     *
     * [--encrypt-response=<bool>]
     * : Encrypt responses if the AES key is provided.
     *
     * [--debug-response=<bool>]
     * : Save extended logs to a file.
     *
     * [--trace-hooks=<bool>]
     * : Trace hooks executed in WP Admin and during the AutoUpdater request.
     *
     * [--output=<format>]
     * : Output format of settings to display.
     * ---
     * default: yaml
     * options:
     *   - json
     *   - yaml
     *
     * @when after_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        if (empty($args) || $args[0] === 'get') {
            $this->getSettings($assoc_args);
            return;
        }

        if ($args[0] === 'set') {
            $this->setSettings($assoc_args);
            return;
        }
    }

    /**
     * @param array $assoc_args
     */
    protected function getSettings($assoc_args)
    {
        $settings = $this->getRemoteSettings();

        foreach ($this->local_options as $option) {
            $local_property = $api_property = str_replace('-', '_', $option);
            if ($option === 'debug-response') {
                $local_property = 'debug';
            }
            if (in_array($option, $this->api_options) && property_exists($settings, $api_property)) {
                continue;
            }
            $settings->{$api_property} = $this->castOptionValue($option, AutoUpdater_Config::get($local_property));
        }

        if ($assoc_args['output'] === 'json') {
            WP_CLI::line(json_encode(
                $settings,
                JSON_PRETTY_PRINT // phpcs:ignore PHPCompatibility.Constants.NewConstants
            ));
        } elseif ($assoc_args['output'] === 'yaml') {
            WP_CLI\Utils\format_items('yaml', array(array('settings' => $settings)), array(
                'settings',
            ));
        }
    }

    /**
     * @param string $read_mask
     *
     * @return object
     */
    protected function getRemoteSettings($read_mask = '')
    {
        $settings = $this->getRawRemoteSettings($read_mask);
        $this->getPluginSettings($settings);
        $this->getThemeSettings($settings);

        return $settings;
    }

    /**
     * @param string $read_mask
     *
     * @return object
     */
    protected function getRawRemoteSettings($read_mask = '')
    {
        $this->validateBeforeApiRequest();

        $response = AutoUpdater_Request::api('GET', 'sites/{ID}', array(
            'read_mask' => $read_mask ? $read_mask : str_replace('-', '_', implode(',', $this->api_options)),
        ))->send();

        $settings = new stdClass();
        if ($response->code !== 200 || !isset($response->body->site)) {
            WP_CLI::error(sprintf('Failed to get remote settings. API responded with HTTP %d %s.', $response->code, $response->message), false);
        } else {
            $settings = $response->body->site;

            // Remove unwanted properties from the response
            foreach ($settings as $key => $value) {
                if (!in_array(str_replace('_', '-', $key), $this->api_options)) {
                    unset($settings->{$key});
                }
            }
        }

        return $settings;
    }

    /**
     * @param object $settings
     */
    protected function getPluginSettings($settings)
    {
        if (!property_exists($settings, 'plugins')) {
            return;
        }

        $settings->excluded_plugins = array();
        $settings->excluded_plugin_updates = array();
        foreach ($settings->plugins as $data) {
            if (isset($data->updates_enabled) && !$data->updates_enabled) {
                $settings->excluded_plugins[] = $data->slug;
                continue;
            }

            if (isset($data->update) && isset($data->update->excluded) && $data->update->excluded) {
                $settings->excluded_plugin_updates[] = $data->slug;
            }
        }

        unset($settings->plugins);
    }

    /**
     * @param object $settings
     */
    protected function getThemeSettings($settings)
    {
        if (!property_exists($settings, 'themes')) {
            return;
        }

        $settings->excluded_themes = array();
        $settings->excluded_theme_updates = array();
        foreach ($settings->themes as $data) {
            if (isset($data->updates_enabled) && !$data->updates_enabled) {
                $settings->excluded_themes[] = $data->slug;
                continue;
            }

            if (isset($data->update) && isset($data->update->excluded) && $data->update->excluded) {
                $settings->excluded_theme_updates[] = $data->slug;
            }
        }

        unset($settings->themes);
    }

    /**
     * @param array $assoc_args
     */
    protected function setSettings($assoc_args)
    {
        if (!$this->validate($assoc_args)) {
            return;
        }

        $success = $this->saveRemoteSettings($assoc_args);

        foreach ($this->local_options as $option) {
            if (!isset($assoc_args[$option])) {
                continue;
            } elseif (is_null($success)) {
                $success = true;
            }

            $value = $this->castOptionValue($option, $assoc_args[$option]);
            if ($option === 'debug-response') {
                $option = 'debug';
            }
            // Store bool options as integer to avoid false settings save failure
            if (in_array($option, $this->bool_options)) {
                $value = (int) $value;
            }
            $success = AutoUpdater_Config::set(str_replace('-', '_', $option), $value) && $success;
        }

        if ($success === true) {
            WP_CLI::success('Settings have been saved.');
        } elseif ($success === false) {
            WP_CLI::error('Failed to save settings.');
        } else {
            WP_CLI::line('No settings to save.');
        }
    }

    /**
     * @param array $assoc_args
     *
     * @return bool|null True on success, false on failure, null when nothing to be saved
     */
    protected function saveRemoteSettings($assoc_args)
    {
        $payload = array();
        foreach ($this->api_options as $option) {
            if (!isset($assoc_args[$option])) {
                continue;
            }
            $value = $this->castOptionValue($option, $assoc_args[$option]);
            if ($option === 'vrt-css-exclusions' && $value) {
                $value = str_replace(',', "\n", $value);
            }
            $payload[str_replace('-', '_', $option)] = $value;
        }

        $this->setPluginSettings($payload, $assoc_args);
        $this->setThemeSettings($payload, $assoc_args);

        if (empty($payload)) {
            return null;
        }

        $this->validateBeforeApiRequest();

        $response = AutoUpdater_Request::api('PATCH', 'sites/{ID}', array(), $payload)->send();
        if ($response->code !== 200) {
            WP_CLI::error(sprintf('Failed to save remote settings. API responded with HTTP %d %s.', $response->code, $response->message));
            return false;
        }

        return true;
    }

    /**
     * @param array $payload
     * @param array $assoc_args
     */
    protected function setPluginSettings(&$payload, $assoc_args)
    {
        if (!isset($assoc_args['excluded-plugins'])) {
            return;
        }

        $settings = $this->getRawRemoteSettings('plugins');
        if (!property_exists($settings, 'plugins')) {
            WP_CLI::warning('There are no plugins to exclude because there are no plugins saved on the remote.');
            return;
        }

        $excluded_plugins = $this->castArray($assoc_args['excluded-plugins']);

        $payload['plugins'] = array();
        foreach ($settings->plugins as $plugin) {
            $payload['plugins'][] = array(
                'id' => $plugin->id,
                'updates_enabled' => !(in_array($plugin->slug, $excluded_plugins) || in_array(dirname($plugin->slug), $excluded_plugins))
            );
        }
    }
    /**
     * @param array $payload
     * @param array $assoc_args
     */
    protected function setThemeSettings(&$payload, $assoc_args)
    {
        if (!isset($assoc_args['excluded-themes'])) {
            return;
        }

        $settings = $this->getRawRemoteSettings('themes');
        if (!property_exists($settings, 'themes')) {
            WP_CLI::warning('There are no themes to exclude because there are no themes saved on the remote.');
            return;
        }

        $excluded_themes = $this->castArray($assoc_args['excluded-themes']);

        $payload['themes'] = array();
        foreach ($settings->themes as $theme) {
            $payload['themes'][] = array(
                'id' => $theme->id,
                'updates_enabled' => !in_array($theme->slug, $excluded_themes)
            );
        }
    }

    /**
     * @param array $assoc_args
     *
     * @return bool
     */
    protected function validate($assoc_args)
    {
        $result = true;

        if (isset($assoc_args['notification-emails'])) {
            $result = $this->validateNotificationEmails($assoc_args['notification-emails']) && $result;
        }

        if (isset($assoc_args['excluded-plugins'])) {
            $result = $this->validateExcludedPlugins($assoc_args['excluded-plugins']) && $result;
        }

        if (isset($assoc_args['excluded-themes'])) {
            $result = $this->validateExcludedThemes($assoc_args['excluded-themes']) && $result;
        }

        if (isset($assoc_args['frontend-url'])) {
            $result = $this->validateFrontendUrl($assoc_args['frontend-url']) && $result;
        }

        if (isset($assoc_args['backend-url'])) {
            $result = $this->validateBackendUrl($assoc_args['backend-url']) && $result;
        }

        if (isset($assoc_args['sitemap-url'])) {
            $result = $this->validateSitemapUrl($assoc_args['sitemap-url']) && $result;
        }

        if (isset($assoc_args['worker-token'])) {
            $result = $this->validateWorkerToken($assoc_args['worker-token']) && $result;
        }

        if (isset($assoc_args['aes-key'])) {
            $result = $this->validateAesKey($assoc_args['aes-key']) && $result;
        }

        if (isset($assoc_args['vrt-urls-limit'])) {
            $result = $this->validateVrtUrlsLimit($assoc_args['vrt-urls-limit']) && $result;
        }

        $result = $this->validateIntOptions($assoc_args) && $result;

        return $this->validateBoolOptions($assoc_args) && $result;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateNotificationEmails($value)
    {
        if (strlen($value) > 500) {
            WP_CLI::error('The email addresses have exceeded 500 bytes.', false);
            return false;
        }
        $result = true;
        $emails = $this->castArray($value);
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                WP_CLI::error(sprintf('The email address %s is not valid.', $email), false);
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateExcludedPlugins($value)
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        $result = true;
        $plugins = $this->castArray($value);
        foreach ($plugins as $plugin) {
            if (substr($plugin, -4) !== '.php') {
                @list($plugin_file) = array_keys(get_plugins("/{$plugin}")); // ignore notice on empty array
                if ($plugin_file) {
                    $plugin = "{$plugin}/{$plugin_file}";
                }
            }
            /** @var WP_Error $err */
            $err = validate_plugin($plugin);
            if ($err !== 0) {
                WP_CLI::error(sprintf('%s %s', $err->get_error_message(), $plugin), false);
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateExcludedThemes($value)
    {
        require_once ABSPATH . WPINC . '/theme.php';

        $result = true;
        $themes = $this->castArray($value);
        foreach ($themes as $theme) {
            /** @var WP_Theme $theme */
            $theme = wp_get_theme($theme);
            /** @var WP_Error $err */
            $err = $theme->errors();
            if ($err !== false) {
                WP_CLI::error($err->get_error_message(), false);
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string $value
     * @param string $url_kind
     *
     * @return bool
     */
    protected function validateUrl($value, $url_kind = '')
    {
        if (empty($value)) {
            return true;
        }
        if (strlen($value) > 255) {
            WP_CLI::error(sprintf('The %s URL has exceeded 255 characters.', $url_kind), false);
            return false;
        }
        if (filter_var(trim($value), FILTER_VALIDATE_URL) === false) {
            WP_CLI::error(sprintf('The %s URL is invalid.', $url_kind), false);
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateFrontendUrl($value)
    {
        return $this->validateUrl($value, 'frontend');
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateBackendUrl($value)
    {
        return $this->validateUrl($value, 'backend');
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateSitemapUrl($value)
    {
        return $this->validateUrl($value, 'sitemap');
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateWorkerToken($value)
    {
        if (strlen($value) !== 32 || !preg_match('/^[a-zA-Z0-9]$/', $value)) {
            WP_CLI::error('The worker token has to be 32 characters length and can contain a-z, A-Z and 0-9 only.', false);
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateAesKey($value)
    {
        if (strlen($value) !== 32 || !preg_match('/^[a-zA-Z0-9]$/', $value)) {
            WP_CLI::error('The AES key has to be 32 characters length and can contain a-z, A-Z and 0-9 only.', false);
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function validateVrtUrlsLimit($value)
    {
        if ($value < 0 || $value > 20) {
            WP_CLI::error('The VRT URLs limit has to be between 0 and 20.', false);
            return false;
        }

        return true;
    }

    protected function validateBeforeApiRequest()
    {
        if (!AutoUpdater_Config::get('site_id')) {
            WP_CLI::error('The site ID is missing.');
            return;
        }
        if (!AutoUpdater_Config::get('worker_token')) {
            WP_CLI::error('The worker token is missing.');
            return;
        }
    }

    public static function beforeInvoke()
    {
        // Do nothing
    }
}
