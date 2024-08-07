<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Helper_SiteTransient
{
    protected $registered_hooks = array();
    protected $transients = array();
    protected $transient_deleted_by = array();

    public function __construct()
    {
        if (!AutoUpdater_Config::get('protect_site_transient', 1)) {
            return;
        }

        // Restore updates data if another plugin overwritten it
        add_action('pre_set_site_transient_update_plugins', array($this, 'protectSiteTransientOnUpdate'), 1, 2);
        add_action('pre_set_site_transient_update_themes', array($this, 'protectSiteTransientOnUpdate'), 1, 2);

        // Restore updates data if another plugin deleted it just before update
        add_action('delete_site_transient_update_plugins', array($this, 'storeSiteTransientBeforeDeletion'), 1, 1);
        add_action('delete_site_transient_update_themes', array($this, 'storeSiteTransientBeforeDeletion'), 1, 1);
        add_action('deleted_site_transient', array($this, 'restoreSiteTransientAfterDeletion'), 1, 1);
    }

    /**
     * Filters the value of a specific site transient before it is set.
     *
     * @param mixed  $value          New value of site transient.
     * @param string $transient_name Transient name.
     *
     * @return mixed $value
     */
    public function protectSiteTransientOnUpdate($value = null, $transient_name = '')
    {
        if (!$transient_name) {
            return $value;
        }

        $this->registerPreSetSiteTransientHooks($transient_name);

        /**
         * Expecting $value to be an object with properties:
         * - int last_checked
         * - array response
         * - array translations
         * - array no_update
         */
        // Does the current transient have any updates data?
        if ($value && !empty($value->response)) {
            if (!empty($this->transients[$transient_name]) && !empty($this->transients[$transient_name]->response)) {
                // Restore updates from cached transient in case some of them were removed from the current one
                $value->response = array_merge(
                    $value->response,
                    $this->transients[$transient_name]->response
                );
            }
            // Store transient
            $this->transients[$transient_name] = $value;
        } elseif (!empty($this->transients[$transient_name])) {
            // Restore transient
            $value = $this->transients[$transient_name];
        }

        return $value;
    }

    /**
     * Adds additional hooks between the existing ones
     *
     * Example list of hooks registered by plugins
     * - Plugin A
     * - Plugin B
     * - Plugin C
     *
     * Example list of hooks after registering our protection of site transient
     * - protectSiteTransientOnUpdate
     * - Plugin A
     * - protectSiteTransientOnUpdate
     * - Plugin B
     * - protectSiteTransientOnUpdate
     * - Plugin C
     * - protectSiteTransientOnUpdate
     *
     * @param string $transient_name Transient name.
     */
    protected function registerPreSetSiteTransientHooks($transient_name)
    {
        global $wp_filter;

        $tag = "pre_set_site_transient_{$transient_name}";
        if (isset($this->registered_hooks[$tag])) {
            // Initialize only once
            return;
        }
        $this->registered_hooks[$tag] = true;

        /** @var WP_Hook $wp_hook */
        $wp_hook = $wp_filter[$tag];
        $helper = $this;

        foreach ($wp_hook->callbacks as $priority => $hooks) {
            // Remove all callbacks. They will be restored later
            $wp_hook->callbacks[$priority] = array();

            foreach ($hooks as $idx => $hook) {
                $was_previous_self_hook = false;
                // Is this hook that is being currently executed?
                if (strpos($idx, 'protectSiteTransientOnUpdate') !== false) {
                    $was_previous_self_hook = true;
                    // Restore hook
                    $wp_hook->callbacks[$priority][$idx] = $hook;
                    continue;
                }

                if (!$was_previous_self_hook) {
                    // Prepend hook to store site transient before running the next hook
                    // and to restore site transient in case it was overwritten by the previous hook
                    $wp_hook->add_filter($tag, function ($value = null, $transient_name = '') use ($helper) {
                        return $helper->protectSiteTransientOnUpdate($value, $transient_name);
                    }, $priority, 2);
                }
                // Restore hook
                $wp_hook->callbacks[$priority][$idx] = $hook;
            }

            if (!$was_previous_self_hook) {
                // Append hook to restore site transient after running the last hook
                $wp_hook->add_filter($tag, function ($value = null, $transient_name = '') use ($helper) {
                    return $helper->protectSiteTransientOnUpdate($value, $transient_name);
                }, $priority, 2);
            }
        }
    }

    /**
     * @param string $transient_name Transient name
     * @return bool
     */
    public function storeSiteTransientBeforeDeletion($transient_name = '')
    {
        if (!$transient_name) {
            return;
        }

        $slug = $this->getPluginDeletingSiteTransient(true);
        if ($slug === 'wordpress') {
            // Do nothing when transient was deleted by WordPress core
            return;
        }

        // Store transient deleted by plugin
        $this->transients[$transient_name] = get_site_transient($transient_name);

        if ($slug && !in_array($slug, $this->transient_deleted_by)) {
            $this->transient_deleted_by[] = $slug;
        }
    }

    /**
     * @param string $transient_name Transient name
     * @return bool
     */
    public function restoreSiteTransientAfterDeletion($transient_name = '')
    {
        if (!$transient_name) {
            return;
        }

        $slug = $this->getPluginDeletingSiteTransient();
        if ($slug === 'wordpress') {
            // Do nothing when transient was deleted by WordPress core
            return;
        }

        if (empty($this->transients[$transient_name])) {
            return;
        }

        // Restore site transient that was deleted by plugin
        $this->set_site_transient($transient_name, $this->transients[$transient_name]);
        $this->clearSiteTransientCache($transient_name);
    }

    /**
     * Fires after the value for a site transient has been set.
     *
     * @param string $transient_name The name of the site transient.
     * @param mixed  $value          Site transient value.
     * @param int    $expiration     Time until expiration in seconds.
     */
    public function clearSiteTransientCache($transient_name = '', $value = null, $expiration = 0)
    {
        unset($this->transients[$transient_name]);
    }

    /**
     * @see set_site_transient()
     *
     * @param string $transient  Transient name. Expected to not be SQL-escaped. Must be
     *                           167 characters or fewer in length.
     * @param mixed  $value      Transient value. Expected to not be SQL-escaped.
     * @param int    $expiration Optional. Time until expiration in seconds. Default 0 (no expiration).
     * @return bool True if the value was set, false otherwise.
     */
    protected function set_site_transient($transient, $value, $expiration = 0)
    {
        // This function is a copy of set_site_transient without calling filters and actions
        // See wordpress/wp-includes/option.php
        $expiration = (int) $expiration;

        if (wp_using_ext_object_cache()) {
            $result = wp_cache_set($transient, $value, 'site-transient', $expiration); // phpcs:ignore
        } else {
            $transient_timeout = '_site_transient_timeout_' . $transient;
            $option            = '_site_transient_' . $transient;

            if (false === get_site_option($option)) {
                if ($expiration) {
                    add_site_option($transient_timeout, time() + $expiration);
                }
                $result = add_site_option($option, $value);
            } else {
                if ($expiration) {
                    update_site_option($transient_timeout, time() + $expiration);
                }
                $result = update_site_option($option, $value);
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function wasSiteTransientDeleted()
    {
        return did_action('delete_site_transient_update_plugins') > 0 || did_action('delete_site_transient_update_themes') > 0;
    }

    /**
     * @return string|bool Returns false when it is not possible to get backtrace
     */
    protected function getPluginDeletingSiteTransient($log = false)
    {
        if (!function_exists('debug_backtrace') || !is_callable('debug_backtrace')) {
            AutoUpdater_Log::debug('Function debug_backtrace is not available.');
            return false;
        }

        // Track what plugin deleted transient
        $backtrace = debug_backtrace(); // phpcs:ignore
        foreach ($backtrace as $trace) {
            if (!isset($trace['file']) || !isset($trace['function']) || $trace['function'] !== 'delete_site_transient') {
                continue;
            }

            // Extract plugin or theme slug from file backtrace
            // Example: /path/to/wordpress/wp-content/plugins/slug/file.php
            if (preg_match('/' . str_replace('/', '\/', WP_CONTENT_DIR) . '\/(?:plugins|themes)\/([^\/]+)/i', $trace['file'], $match)) {
                if ($log && AutoUpdater_Config::get('debug')) {
                    AutoUpdater_Log::debug(print_r($backtrace, true));
                }
                return $match[1];
            }
        }

        return 'wordpress';
    }

    /**
     * @return array
     */
    public function getAllPluginsDeletingSiteTransient()
    {
        if (empty($this->transient_deleted_by)) {
            return array('unknown');
        }

        return $this->transient_deleted_by;
    }

    /**
     *
     * Convinces WordPress that we are currently viewing the update-core.php page.
     *
     */
    public static function simulateUpdateCorePage()
    {
        // Done on purpose
        global $pagenow;
        $pagenow = 'update-core.php'; // phpcs:ignore

        do_action('load-update-core.php');
    }
}
