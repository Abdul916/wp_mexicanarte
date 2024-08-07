<?php
function_exists('add_action') or die;

class AutoUpdater_WP_Admin
{
    protected static $instance = null;
    protected $menu_slug = 'autoupdater';

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        static::$instance = new AutoUpdater_WP_Admin();

        return static::$instance;
    }

    /**
     * @return string
     */
    public static function getSettingsUrl()
    {
        $uri_append = defined('PWP_NAME') ? '/redirect/_/' . PWP_NAME : '';
        $stage = AutoUpdater_Config::get('stage');
        if ($stage) {
            return 'https://mystaging.wpengine.com/products/smart_plugin_manager' . $uri_append;
        }
        return 'https://my.wpengine.com/products/smart_plugin_manager' . $uri_append;
    }

    public function __construct()
    {
        if (!is_admin()) {
            return;
        }

        global $pagenow;
        if ($pagenow === 'update-core.php') {
            AutoUpdater_Log::debug('---------- Displaying WP-Admin update-core.php page ----------');
            AutoUpdater_Log::traceHooks();
        }

        add_filter('plugin_auto_update_setting_html', array($this, 'getAutoUpdateSettingHtml'));

        $whitelabelling = AutoUpdater_WP_Whitelabelling::getInstance();
        $this->menu_slug = $whitelabelling->getWhiteLabeledSlug();
        if (!$whitelabelling->isPluginHidden()) {
            add_action('admin_init', array($this, 'maintenanceOff'));
            add_action('admin_init', array($this, 'redirectToConfigurationPage'));
            add_action('admin_menu', array($this, 'addMenuEntry'));
        }

        add_filter('site_status_tests', array($this, 'turnOffHealthCheckPluginthemeAutoUpdates'));
    }

    /**
     * @return string
     */
    public function getMenuSlug()
    {
        return $this->menu_slug;
    }

    /**
     * Add menu entry with plug-in settings page.
     */
    public function addMenuEntry()
    {
        $name = AutoUpdater_WP_Whitelabelling::getInstance()
            ->getWhiteLabeledName(AUTOUPDATER_WP_PLUGIN_NAME);

        add_management_page(
            $name,
            $name,
            'manage_options',
            $this->menu_slug,
            array($this, 'displayConfigurationPage')
        );

        if ($this->menu_slug != 'autoupdater') {
            add_submenu_page(
                '',
                $name,
                $name,
                'manage_options',
                'autoupdater',
                array($this, 'displayConfigurationPage')
            );
        };

        // Display "Turn off maintenance" in admin menu if it is enabled for longer than 15 minutes or for an unknown time
        if (!AutoUpdater_Maintenance::getInstance()->isEnabled()) {
            return;
        }

        $date = AutoUpdater_Config::get('maintenance_started_at');
        if ($date) {
            $date = new DateTime($date);
            if ((time() - $date->getTimestamp()) / 60 < 15) {
                return;
            }
        }

        add_menu_page(
            'Turn off maintenance',
            'Turn off maintenance',
            'manage_options',
            admin_url('tools.php?page=autoupdater-maintenance-off'),
            '',
            'dashicons-admin-site',
            0
        );

        add_submenu_page(
            '',
            'Turning off maintenance',
            'Turning off maintenance',
            'manage_options',
            'autoupdater-maintenance-off'
        );
    }

    public function maintenanceOff()
    {
        global $pagenow;

        if ($pagenow != 'tools.php' || AutoUpdater_Request::getQueryVar('page') != 'autoupdater-maintenance-off') {
            return;
        }

        AutoUpdater_Maintenance::getInstance()->disable();

        wp_safe_redirect(admin_url(), 302);
        exit;
    }

    /**
     * Redirects wp-admin/tools.php?page=autoupdater to the configuration page with the white labelled menu slug
     */
    public function redirectToConfigurationPage()
    {
        global $pagenow;

        if (
            $pagenow != 'tools.php' || AutoUpdater_Request::getQueryVar('page') == $this->menu_slug ||
            AutoUpdater_Request::getQueryVar('page') != 'autoupdater'
        ) {
            return;
        }

        wp_safe_redirect(menu_page_url($this->menu_slug, false), 301);
        exit;
    }

    public function displayConfigurationPage()
    {
?>
            <script>
                location.href = "<?php echo self::getSettingsUrl() /* phpcs:ignore */ ?>";
            </script>
            <a href="<?php echo esc_url(self::getSettingsUrl()) ?>" target="_blank">
                <?php esc_html_e('Settings') ?>
            </a>
<?php
    }

    /**
     * Filters the HTML of the auto-updates setting for each plugin in the Plugins list table.
     *
     * @since WordPress 5.5.0
     *
     * @param string $html        The HTML of the plugin's auto-update column content, including
     *                            toggle auto-update action links and time to next update.
     * @param string $plugin_file Path to the plugin file relative to the plugins directory.
     * @param array  $plugin_data An array of plugin data.
     *
     * @return string
     */
    public function getAutoUpdateSettingHtml($html = '', $plugin_file = '', $plugin_data = array())
    {
        return
            '<a href="' . esc_url(self::getSettingsUrl()) . '" target="_blank" title="' . esc_attr__('Automatic updates work only for plugins recognized by WordPress.org, or that include a compatible update system.', 'autoupdater') . '">'
            . sprintf(__('Managed by %s', 'autoupdater'), AUTOUPDATER_WP_PLUGIN_NAME)
            . '</a>';
    }

    /**
     * Disable the Site Health test which warns against disabling WordPress auto-updates as a critical security issue.
     *
     * @since WordPress 5.2.0
     *
     * @param array $tests An array of tests that are performed during the Site Health check.
     *
     * @return array
     */
    public function turnOffHealthCheckPluginthemeAutoUpdates($tests = array())
    {
        if (is_array($tests) && isset($tests['direct']) && isset($tests['direct']['plugin_theme_auto_updates'])) {
            unset($tests['direct']['plugin_theme_auto_updates']);
        }
        return $tests;
    }
}
