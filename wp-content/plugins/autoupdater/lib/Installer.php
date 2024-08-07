<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Installer
{
    protected static $instance = null;
    protected $uninstalled = false;
    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        $class_name = AutoUpdater_Loader::loadClass('Installer');

        static::$instance = new $class_name();

        return static::$instance;
    }

    public function __construct()
    {
        register_activation_hook(AUTOUPDATER_WP_PLUGIN_FILE, array($this, 'install'));
        register_uninstall_hook(AUTOUPDATER_WP_PLUGIN_FILE, array('AutoUpdater_Installer', 'hookUninstall'));

        add_action('init', array($this, 'selfUpdate'), 0);
    }

    /**
     * @return bool
     */
    public function install()
    {
        $result = true;
        AutoUpdater_Log::debug(sprintf('Installing worker %s', AUTOUPDATER_VERSION));

        if (!AutoUpdater_Config::get('version')) {
            AutoUpdater_Config::set('version', AUTOUPDATER_VERSION);
        }

        $this->createTokens();

        AutoUpdater_Log::debug(sprintf('Worker %s has been installed.', AUTOUPDATER_VERSION));

        // Disable WordPress core automatic updates
        $this->changeWordPressAutomaticUpdates();

        return $result;
    }

    public function selfUpdate()
    {
        if (in_array(AutoUpdater_Request::getQueryVar('wpe_endpoint'), array('child/update/after', 'child/verify'))) {
            // Do not run self-update as we are running it through API
            return;
        }

        $version = AutoUpdater_Config::get('version', '2.0');
        if (version_compare($version, AUTOUPDATER_VERSION, '<')) {
            $this->update();
        }
    }

    /**
     * @return bool
     */
    public function update()
    {
        $old_version = AutoUpdater_Config::get('version', '2.0');
        $new_version = $this->getVersion();

        AutoUpdater_Log::debug(sprintf('Updating worker from version %s to %s', $old_version, $new_version));
        if (version_compare($old_version, $new_version, '<')) {
            AutoUpdater_Config::set('version', $new_version);
        }

        AutoUpdater_Loader::loadClass('InstallerPostUpdate');
        AutoUpdater_InstallerPostUpdate::run($old_version, $new_version);

        AutoUpdater_Log::debug(sprintf('Worker has been updated from version %s to %s', $old_version, $new_version));

        return true;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        $data = get_file_data(AUTOUPDATER_WP_PLUGIN_FILE, array('Version' => 'Version'));
        return $data['Version'];
    }

    /**
     * @return bool
     */
    protected function createTokens()
    {
        if (!AutoUpdater_Config::get('worker_token')) {
            AutoUpdater_Config::set('worker_token', $this->generateToken());
        }
        if (!AutoUpdater_Config::get('aes_key')) {
            AutoUpdater_Config::set('aes_key', $this->generateToken());
        }

        return true;
    }

    /**
     * @return string
     */
    protected function generateToken()
    {
        $key = '';
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($chars)  - 1;
        for ($i = 0; $i < 32; ++$i) {
            $key .= $chars[wp_rand(0, $max)];
        }

        return $key;
    }

    /**
     * @param bool $self
     *
     * @return bool
     */
    public function uninstall($self = false)
    {
        // Make sure that it would not run twice with WP register_uninstall_hook
        if ($this->uninstalled) {
            return true;
        }
        $this->uninstalled = true;

        AutoUpdater_Log::debug(sprintf('Uninstalling worker %s', AUTOUPDATER_VERSION));

        AutoUpdater_Config::removeAll();

        AutoUpdater_Log::debug(sprintf('Worker %s has been uninstalled.', AUTOUPDATER_VERSION));

        // Enable WordPress core automatic updates
        $this->changeWordPressAutomaticUpdates(false);

        // Do not delete the plugin if the uninstaller was triggered by the back-end
        // because the plugin will be deleted by the WP core
        if ($self === false) {
            return true;
        }

        if (is_plugin_active(AUTOUPDATER_WP_PLUGIN_SLUG)) {
            deactivate_plugins(AUTOUPDATER_WP_PLUGIN_SLUG);
        }

        if (is_uninstallable_plugin(AUTOUPDATER_WP_PLUGIN_SLUG)) {
            include_once ABSPATH . 'wp-admin/includes/file.php';
            if (delete_plugins(array(AUTOUPDATER_WP_PLUGIN_SLUG)) !== true) {
                return false;
            }
        }

        return true;
    }

    public static function hookUninstall()
    {
        AutoUpdater_Installer::getInstance()->uninstall();
    }

    /**
     * @param bool $disable
     */
    protected function changeWordPressAutomaticUpdates($disable = true)
    {
        // setup file path
        $file = ABSPATH . 'wp-config.php';
        $filemanager = AutoUpdater_Filemanager::getInstance();

        //check if file exists
        if (!$filemanager->exists($file)) {
            return;
        }
        // grab content of that file
        $content = $filemanager->get_contents($file);

        $closing_php_position = strrpos($content, '?>');
        if ($closing_php_position !== false) {
            $content = substr_replace($content, '', $closing_php_position, strlen('?>'));
        }

        // search for automatic updater
        preg_match('/(?:define\s*\(\s*[\'"]AUTOMATIC_UPDATER_DISABLED[\'"]\s*,\s*)(false|true|1|0)(?:\s*\);)/i', $content, $match);

        // if $match empty we don't have this variable in file
        if (!empty($match)) {
            if (($disable === true && ($match[1] === 'true' || $match[1] === '1')) || ($disable === false && ($match[1] === 'false' || $match[1] === '0'))
            ) {
                return;
            }

            // modify this constant : )
            $content = str_replace(
                $match[0],
                'define(\'AUTOMATIC_UPDATER_DISABLED\', ' . ($disable ? 'true' : 'false') . ');',
                $content
            );
        } else {
            // so lets create this constant : )
            $content = str_replace(
                '/**#@-*/',
                'if (!defined(\'AUTOMATIC_UPDATER_DISABLED\')) define(\'AUTOMATIC_UPDATER_DISABLED\', ' . ($disable ? 'true' : 'false') . ');',
                $content
            );
        }

        // save it to file
        $filemanager->put_contents($file, $content . PHP_EOL);
    }
}
