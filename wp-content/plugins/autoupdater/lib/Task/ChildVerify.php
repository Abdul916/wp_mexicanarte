<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ChildVerify extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /**
     * @return array
     */
    public function doTask()
    {
        if (is_multisite() && !is_plugin_active_for_network(AUTOUPDATER_WP_PLUGIN_SLUG)) {
            $result = activate_plugin(AUTOUPDATER_WP_PLUGIN_SLUG, '', true);
            if (is_wp_error($result)) {
                /** @var WP_Error $result */
                throw AutoUpdater_Exception_Response::getException(
                    400,
                    'Failed to activate plugin network-wide',
                    $result->get_error_code(),
                    $result->get_error_message()
                );
            }
        }

        return array(
            'success' => true,
        );
    }
}
