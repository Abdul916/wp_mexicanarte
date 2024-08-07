<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Config
{
    protected static $prefix = 'autoupdater_';

    /**
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (in_array($key, array('worker_token', 'aes_key'))) {
            return static::getRaw($key, $default);
        }

        return is_multisite() ? get_blog_option(1, static::$prefix . $key, $default) : get_option(static::$prefix . $key, $default);
    }

    /**
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    protected static function getRaw($key, $default = null)
    {
        global $wpdb;
        $value = $wpdb->get_var(
            $wpdb->prepare("SELECT option_value FROM {$wpdb->get_blog_prefix(1)}options WHERE option_name = %s LIMIT 1", static::$prefix . $key)
        );

        if (is_null($value)) {
            return $default;
        }

        return $value;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public static function set($key, $value)
    {
        $is_multisite = is_multisite();
        $old_value = $is_multisite ? get_blog_option(1, static::$prefix . $key, null) : get_option(static::$prefix . $key, null);
        // Possible comparison of values string(1) "0" and int(0) so don't use identical operator
        if ($old_value == $value && !is_null($old_value)) {
            return true;
        }

        return $is_multisite ? update_blog_option(1, static::$prefix . $key, $value) : update_option(static::$prefix . $key, $value);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public static function remove($key)
    {
        return is_multisite() ? delete_blog_option(1, static::$prefix . $key) : delete_option(static::$prefix . $key);
    }

    /**
     * @return bool
     */
    public static function removeAll()
    {
        global $wpdb;

        $options = $wpdb->get_col(
            $wpdb->prepare(
                'SELECT option_name'
                    . ' FROM ' . $wpdb->get_blog_prefix(1) . 'options'
                    . ' WHERE option_name LIKE %s',
                static::$prefix . '%'
            )
        );

        $is_multisite = is_multisite();
        foreach ($options as $option) {
            $is_multisite ? delete_blog_option(1, $option) : delete_option($option);
        }

        return true;
    }

    /**
     * @return string
     */
    public static function getSiteUrl()
    {
        return rtrim(get_home_url(), '/');
    }

    /**
     * @return string
     */
    public static function getSiteBackendUrl()
    {
        return rtrim(get_admin_url(), '/');
    }

    /**
     * @return string
     */
    public static function getSiteLanguage()
    {
        return str_replace('_', '-', get_option('WPLANG', defined('WPLANG') && WPLANG ? WPLANG : 'en_US'));
    }

    /**
     * @return string
     */
    public static function getAutoUpdaterApiBaseUrl()
    {
        $stage = static::get('stage');
        $stage = ($stage === 'dev') ? 'development' : $stage;
        return 'https://api.' . ($stage ? $stage : 'production') . '.au.wpesvc.net/v3/';
    }
}
