<?php
function_exists('add_action') or die;

/**
 * Exclude requests by
 *
 * Cookie
 *  cookie name: autoupdater
 *  cookie value: 1
 *  cookie name: wpengine_no_cache
 *  cookie value: 1
 *
 * Header
 *  header name: autoupdater
 *  header value: 2.0
 *
 * URL query parameter
 *  param name: autoupdater
 *  param value: api
 *  param name: autoupdater_nonce
 *  param value: {timestamp}
 */
class AutoUpdater_Helper_Cache
{
    /**
     * Sets cache exclusion rules that apply only when meet the given criteria
     */
    public static function setCacheExclusionRules()
    {
        // WP Optimize cache exclusion rules
        add_filter('wpo_cache_exception_cookies', function ($cache_exception_cookies = array()) {
            if (!is_array($cache_exception_cookies)) {
                $cache_exception_cookies = array();
            }
            $cache_exception_cookies[] = 'wpengine_no_cache';
            $cache_exception_cookies[] = 'autoupdater';
            return $cache_exception_cookies;
        });
    }

    /**
     * Turns off caching immediately
     */
    public static function noCache()
    {
        // WP Optimize cache exclusion
        add_filter('wpo_restricted_cache_page_type', function ($restricted = false) {
            return 'Installing plugin and theme updates';
        });
    }
}
