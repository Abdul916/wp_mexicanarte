<?php
function_exists('add_action') or die;

class AutoUpdater_WP_Whitelabelling
{
    protected static $instance = null;
    protected $hidden = false;

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        static::$instance = new AutoUpdater_WP_Whitelabelling();

        return static::$instance;
    }

    public function __construct()
    {
        if (AutoUpdater_Config::get('hide_child') && AutoUpdater_Request::getQueryVar('whitelabel') !== 'off') {
            $this->hidden = true;
        }

        if ($this->hidden) {
            add_filter('all_plugins', array($this, 'hidePlugin'), 10, 1);
            add_filter('site_transient_update_plugins', array($this, 'hideUpdateNotification'), 10, 1);
        }

        add_filter('gettext', array($this, 'whiteLabelName'), 10, 3);
        add_filter('plugin_row_meta', array($this, 'whiteLabelPluginOnList'), 10, 4);
        add_filter('network_admin_plugin_action_links_' . AUTOUPDATER_WP_PLUGIN_SLUG, array($this, 'whiteLabelPluginActions'), 10, 4);
        add_filter('plugin_action_links_' . AUTOUPDATER_WP_PLUGIN_SLUG, array($this, 'whiteLabelPluginActions'), 10, 4);
        add_filter('all_plugins', array($this, 'modifyPluginDescription'));
    }

    /**
     * @return bool
     */
    public function isPluginHidden()
    {
        return $this->hidden;
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getWhiteLabeledName($default = '')
    {
        $name = AutoUpdater_Config::get('whitelabel_name', $default);
        if (empty($name)) {
            $name = $default;
        }

        return $name;
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getWhiteLabeledAuthor($default = '')
    {
        $author = AutoUpdater_Config::get('whitelabel_author', $default);
        if (empty($author)) {
            $author = $default;
        }

        return $author;
    }

    /**
     * @return string
     */
    public function getWhiteLabeledSlug()
    {
        return sanitize_title($this->getWhiteLabeledName(AUTOUPDATER_WP_PLUGIN_NAME), dirname(AUTOUPDATER_WP_PLUGIN_SLUG));
    }

    /**
     * Override AutoUpdater name by filtering.
     *
     * @param string $translations
     * @param string $text
     * @param string $domain
     *
     * @return string
     */
    public function whiteLabelName($translations, $text, $domain = '')
    {
        if ($domain == 'autoupdater' && $text == AUTOUPDATER_WP_PLUGIN_NAME) {
            return $this->getWhiteLabeledName(AUTOUPDATER_WP_PLUGIN_NAME);
        }

        return $translations;
    }

    /**
     * @param array  $plugin_meta An array of the plugin's metadata,
     *                            including the version, author,
     *                            author URI, and plugin URI.
     * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
     * @param array  $plugin_data An array of plugin data.
     * @param string $status      Status of the plugin. Defaults are 'All', 'Active',
     *                            'Inactive', 'Recently Activated', 'Upgrade', 'Must-Use',
     *                            'Drop-ins', 'Search'.
     *
     * @return array
     */
    public function whiteLabelPluginOnList($plugin_meta, $plugin_file, $plugin_data, $status = 'All')
    {
        if (basename($plugin_file, '.php') == AUTOUPDATER_WP_PLUGIN_BASENAME && $this->getWhiteLabeledName()) {
            $plugin_meta = array(
                sprintf(__('Version %s'), $plugin_data['Version']),
            );

            if ($author = AutoUpdater_Config::get('whitelabel_author')) {
                $plugin_meta[] = sprintf(__('By %s'), $author);
            }
        }

        return $plugin_meta;
    }

    /**
     * @param array  $actions     An array of plugin action links.
     * @param string $plugin_file Path to the plugin file relative to the plugins directory.
     * @param array  $plugin_data An array of plugin data.
     * @param string $context     The plugin context. Defaults are 'All', 'Active',
     *                            'Inactive', 'Recently Activated', 'Upgrade',
     *                            'Must-Use', 'Drop-ins', 'Search'.
     *
     * @return array
     */
    public function whiteLabelPluginActions($actions, $plugin_file, $plugin_data, $context = 'All')
    {
        if ($plugin_file !== AUTOUPDATER_WP_PLUGIN_SLUG) {
            return $actions;
        };

        if (!AutoUpdater_Filemanager::getInstance()->exists(AUTOUPDATER_WP_PLUGIN_PATH . 'tmpl/configuration.tmpl.php')) {
            // Link to the Portal settings
            $actions[] = '<a href="' . esc_url(AutoUpdater_WP_Admin::getSettingsUrl()) .'" target="_blank">' . __('Settings') . '</a>';
        } else {
            $actions[] = '<a href=' . esc_url(network_admin_url('tools.php?page=' . $this->getWhiteLabeledSlug())) . '>' . __('Settings') . '</a>';
        }

        if (!AutoUpdater_Config::get('protect_child', 1)) {
            return $actions;
        }

        if (isset($actions['deactivate'])) {
            unset($actions['deactivate']);
        }

        if (isset($actions['details'])) {
            unset($actions['details']);
        }

        if (isset($actions['edit'])) {
            unset($actions['edit']);
        }

        if (isset($actions['delete'])) {
            unset($actions['delete']);
        }

        return $actions;
    }

    /**
     * @param array $plugins
     *
     * @return array
     */
    public function hidePlugin($plugins)
    {
        $slug = AUTOUPDATER_WP_PLUGIN_SLUG;
        if (array_key_exists($slug, $plugins)) {
            unset($plugins[$slug]);
        }

        return $plugins;
    }

    /**
     * @param object $updates_info
     *
     * @return object
     */
    public function hideUpdateNotification($updates_info)
    {
        $slug = AUTOUPDATER_WP_PLUGIN_SLUG;
        if (!empty($updates_info->response[$slug])) {
            unset($updates_info->response[$slug]);
        }

        return $updates_info;
    }

    public function modifyPluginDescription($all_plugins)
    {
        if (
            isset($all_plugins[AUTOUPDATER_WP_PLUGIN_SLUG]) &&
            ($description = AutoUpdater_Config::get('whitelabel_child_page'))
        ) {
            $all_plugins[AUTOUPDATER_WP_PLUGIN_SLUG]['Description'] = $description;
        }

        return $all_plugins;
    }
}
