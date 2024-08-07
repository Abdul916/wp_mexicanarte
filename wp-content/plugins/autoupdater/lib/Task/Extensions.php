<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_Extensions extends AutoUpdater_Task_Base
{
    protected $admin_privileges = true;
    protected $high_priority = false;
    protected $current_theme = '';
    protected $updates = array();

    /**
     * @return array
     */
    public function doTask()
    {
        AutoUpdater_Loader::loadClass('Helper_Version');
        AutoUpdater_Loader::loadClass('Helper_SiteTransient');

        AutoUpdater_Config::set('update_themes', (int) $this->input('update_themes', 0));

        $extensions = $this->getExtensions();

        return array(
            'success' => true,
            'extensions' => array(
                'changed' => $extensions,
                'checksum' => sha1(json_encode($extensions)),
            ),
            /** @see AutoUpdater_Task_Environment::doTask() */
            'environment' => AutoUpdater_Task::getInstance('Environment')->doTask(),
        );
    }

    /**
     * @return array
     */
    protected function getExtensions()
    {
        require_once ABSPATH . '/wp-admin/includes/plugin.php';
        require_once ABSPATH . '/wp-admin/includes/theme.php';

        $extensions = array();
        $this->updates = $this->getUpdatesFromRemoteServers();

        $core = new stdClass();
        $core->name = 'WordPress';
        $core->type = 'core';
        $core->slug = 'wordpress';
        $core->version = AUTOUPDATER_WP_VERSION;
        $core->enabled = 1;
        $core->update = $this->checkForUpdates($core->slug, $core->type);

        $translations = new stdClass();
        $translations->name = 'Translations';
        $translations->type = 'translation';
        $translations->slug = 'core';
        $translations->version = AUTOUPDATER_WP_VERSION;
        $translations->enabled = 1;
        $translations->update = $this->checkForUpdates($translations->slug, $translations->type);

        $extensions[] = $core;
        $extensions[] = $translations;

        $list = get_plugins();

        if (version_compare(AUTOUPDATER_WP_VERSION, '3.4.0', '>=')) {
            $list = array_merge($list, wp_get_themes());
            $this->current_theme = AutoUpdater_Helper_Version::filterHTML(wp_get_theme()->get('Name'));
        } else {
            $list = array_merge($list, get_themes()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_themesFound
            $this->current_theme = AutoUpdater_Helper_Version::filterHTML(get_current_theme()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_get_current_themeFound
        }

        foreach ($list as $slug => $item) {
            if ($item instanceof WP_Theme || isset($item['Template'])) {
                $extensions[] = $this->getThemeInfo($slug, $item);
            } elseif (isset($item['PluginURI'])) {
                $plugin = $this->getPluginInfo($slug, $item);
                $extensions[] = $plugin;
            }
        }

        return $extensions;
    }

    /**
     * @param string $slug
     * @param array  $plugin
     *
     * @return array
     */
    protected function getPluginInfo($slug, $plugin)
    {
        $item = new stdClass();
        $item->name = AutoUpdater_Helper_Version::filterHTML($plugin['Name']);
        $item->type = 'plugin';
        $item->slug = $slug;
        $item->version = strtolower(AutoUpdater_Helper_Version::filterHTML((string) $plugin['Version']));
        $item->enabled = (int) is_plugin_active($slug);
        $item->update = $this->checkForUpdates($item->slug, $item->type);

        if ($slug == AUTOUPDATER_WP_PLUGIN_SLUG) {
            $item->name = AutoUpdater_Helper_Version::filterHTML(AutoUpdater_Config::get('whitelabel_name', $item->name));
        }

        return $item;
    }

    /**
     * @param string         $slug
     * @param array|WP_Theme $theme
     *
     * @return array
     */
    protected function getThemeInfo($slug, $theme)
    {
        /**
         * @var WP_Theme $theme
         * @since 3.4.0
         */
        $legacy = !($theme instanceof WP_Theme);

        // build array with themes data to Dashboard
        $item = new stdClass();
        $item->name = AutoUpdater_Helper_Version::filterHTML($legacy ? $theme['Name'] : $theme->get('Name'));
        $item->type = 'theme';
        $item->slug = $legacy ? $theme['Stylesheet'] : basename($slug);
        $item->version = strtolower(AutoUpdater_Helper_Version::filterHTML((string) ($legacy ? $theme['Version'] : $theme->get('Version'))));
        $item->enabled = (int) ($this->current_theme == $item->name);
        $item->update = $this->checkForUpdates($item->slug, $item->type);

        $template = $legacy ? $theme['Template'] : $theme->get_template();
        if ($template !== $item->slug) {
            $item->parent_slug = (string) $template;
        }

        return $item;
    }

    /**
     * @return array
     */
    protected function getUpdatesFromRemoteServers()
    {
        // Convince WordPress that we're currently viewing the update-core.php page
        AutoUpdater_Helper_SiteTransient::simulateUpdateCorePage();

        // get updates
        $core = get_site_transient('update_core');
        $plugins = get_site_transient('update_plugins');
        $themes = get_site_transient('update_themes');

        $updates = array(
            'wordpress_core' => $this->getCoreUpdate($core)
        );

        if (!empty($plugins->response)) {
            foreach ($plugins->response as $slug => $plugin) {
                if (!is_object($plugin)) {
                    if (!is_array($plugin)) {
                        continue;
                    }
                    $plugin = (object) $plugin;
                }
                if (!empty($plugin->new_version)) {
                    $updates[$slug . '_plugin'] = $this->getUpdate($plugin);
                }
            }
        }

        if (!empty($themes->response)) {
            foreach ($themes->response as $slug => $theme) {
                if (!is_object($theme)) {
                    if (!is_array($theme)) {
                        continue;
                    }
                    $theme = (object) $theme;
                }
                if (!empty($theme->new_version)) {
                    $updates[$slug . '_theme'] = $this->getUpdate($theme);
                }
            }
        }

        $translations = false;
        if (!empty($plugins->translations) || !empty($themes->translations)) {
            $translations = true;
        } else {
            if (!empty($core->translations)) {
                $translations = true;
            }
        }

        if ($translations) {
            $updates['core_translation'] = array(
                'version' => AUTOUPDATER_WP_VERSION . (substr_count(AUTOUPDATER_WP_VERSION, '.') === 1 ? '.0.1' : '.1'),
                'download_url' => null,
                'core_version_max' => AUTOUPDATER_WP_VERSION,
            );
        }

        return $updates;
    }

    /**
     * @param object $update
     *
     * @return array
     */
    protected function getUpdate($update)
    {
        return array(
            'version' => (string) $update->new_version,
            'download_url' => $this->getUpdateDownloadUrl($update),
            'core_version_min' => !empty($update->requires) ? (string) $update->requires : null,
            'core_version_max' => !empty($update->tested) ? (string) $update->tested : null,
            'php_version_min' => !empty($update->requires_php) ? (string) $update->requires_php : null
        );
    }

    /**
     * @param object|null $core_transient
     *
     * @return object|null
     */
    protected function getCoreUpdate($core_transient)
    {
        if (!isset($core_transient->updates) || !is_array($core_transient->updates)) {
            return null;
        }

        $wp_version = AUTOUPDATER_WP_VERSION;
        @list($wp_version_major, $wp_version_minor, $wp_version_dev) = explode($wp_version, '.'); // phpcs:ignore
        $wp_version_next = intval($wp_version_major) . '.' . intval($wp_version_minor) . '.' . ($wp_version_dev ? intval($wp_version_dev) + 1 : 1);

        $wp_upgrade = null;
        $wp_update = null;
        $development = false;

        foreach ($core_transient->updates as $update) {
            if (!is_object($update)) {
                if (!is_array($update)) {
                    continue;
                }
                $update = (object) $update;
            }

            if (in_array($update->response, array('upgrade', 'latest', 'development'))) {
                if (in_array($update->response, array('latest', 'development'))) {
                    $development = true;
                }
                $wp_upgrade = array(
                    'version' => (string) $update->current,
                    'download_url' => $this->getUpdateDownloadUrl($update),
                    'php_version_min' => !empty($update->php_version) ? (string) $update->php_version : null
                );
            }
            elseif ('autoupdate' === $update->response && $wp_version_next === $update->current) {
                $wp_update = array(
                    'version' => (string) $update->current,
                    'download_url' => $this->getUpdateDownloadUrl($update),
                    'php_version_min' => !empty($update->php_version) ? (string) $update->php_version : null
                );
            }
        }

        if ($development || !$wp_update) {
            if ($wp_upgrade['version'] && version_compare($wp_upgrade['version'], AUTOUPDATER_WP_VERSION, '>')) {
                return $wp_upgrade;
            }

            return null;
        }

        if ($wp_update['version'] && version_compare($wp_update['version'], AUTOUPDATER_WP_VERSION, '>')) {
            return $wp_update;
        }

        return null;
    }

    /**
     * @param object $update
     *
     * @return string
     */
    protected function getUpdateDownloadUrl($update)
    {
        if (empty($update->download) && empty($update->package)) {
            return '';
        }

        // Filter and validate download URL
        $download_url = !empty($update->package) ? $update->package : $update->download;
        $download_url = trim(html_entity_decode($download_url, ENT_QUOTES, 'UTF-8'));
        if (filter_var($download_url, FILTER_VALIDATE_URL) === false) {
            return '';
        }

        return $download_url;
    }

    /**
     * @param string $slug
     * @param string $type
     *
     * @return object|null
     */
    protected function checkForUpdates($slug, $type)
    {
        return isset($this->updates[$slug . '_' . $type]) ? $this->updates[$slug . '_' . $type] : null;
    }
}
