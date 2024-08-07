<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ExtensionsUpdatesPurge extends AutoUpdater_Task_Base
{
    public function __construct($payload)
    {
        parent::__construct($payload);

        AutoUpdater_Loader::loadClass('Helper_SiteTransient');
    }

    /**
     * @return array
     */
    public function doTask()
    {
        // Convince WordPress that we're currently viewing the update-core.php page
        AutoUpdater_Helper_SiteTransient::simulateUpdateCorePage();

        $type = $this->input('type', '');

        switch ($type) {
            case 'plugin':
                wp_cache_delete('plugins', 'plugins');
                delete_site_transient('update_plugins');
                break;
            case 'theme':
                delete_site_transient('update_themes');
                break;
            default:
                wp_cache_delete('plugins', 'plugins');
                delete_site_transient('update_plugins');
                delete_site_transient('update_themes');
        }

        return array(
            'success' => true,
            'message' => 'Updates purged successfully',
        );
    }
}
