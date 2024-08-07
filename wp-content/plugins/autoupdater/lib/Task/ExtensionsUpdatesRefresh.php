<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ExtensionsUpdatesRefresh extends AutoUpdater_Task_Base
{
    protected $admin_privileges = true;
    protected $high_priority = false;
    /** @var AutoUpdater_Helper_SiteTransient */
    protected $site_transient;

    public function __construct($payload)
    {
        parent::__construct($payload);

        AutoUpdater_Loader::loadClass('Helper_SiteTransient');

        // Restore updates data if another plugin deleted it just before update
        $this->site_transient = new AutoUpdater_Helper_SiteTransient();
    }

    /**
     * @return array
     */
    public function doTask()
    {
        $type = $this->input('type', '');

        // get updates for exceptional extensions (it must be called here)
        AutoUpdater_Loader::loadClass('Helper_Extension');
        AutoUpdater_Helper_Extension::loadMasterSliderPro();

        // Convince WordPress that we're currently viewing the update-core.php page
        AutoUpdater_Helper_SiteTransient::simulateUpdateCorePage();

        switch ($type) {
            case 'plugin':
                wp_update_plugins();
                break;
            case 'theme':
                wp_update_themes();
                break;
            default:
                wp_update_plugins();
                wp_update_themes();
        }

        return array(
            'success' => true,
            'message' => 'Updates refreshed successfully',
        );
    }
}
