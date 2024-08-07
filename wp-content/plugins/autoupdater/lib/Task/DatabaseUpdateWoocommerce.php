<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_DatabaseUpdateWoocommerce extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */

    public function doTask()
    {
        $success = false;
        $message = '';

        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            return array(
                'success' => true,
                'message' => 'WooCommerce plugin is not active, skipping database update'
            );
        }

        if (
            file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')
            && file_exists(WP_PLUGIN_DIR . '/woocommerce/includes/class-wc-install.php')
            && file_exists(WP_PLUGIN_DIR . '/woocommerce/includes/wc-update-functions.php')
        ) {
            include_once WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
            include_once WP_PLUGIN_DIR . '/woocommerce/includes/class-wc-install.php';
            include_once WP_PLUGIN_DIR . '/woocommerce/includes/wc-update-functions.php';
        }

        if (!defined('WC_PLUGIN_FILE')) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'WooCommerce plugin not loaded'
            );
        }
        
        // code here is mostly adapted from https://github.com/woocommerce/woocommerce/blob/e2bc34cf929e2e76cecda7e9376b2b11509424c1/plugins/woocommerce/includes/cli/class-wc-cli-update-command.php
        // in case of any issues, check out how the latest version differs from what we have here

        if (
            !method_exists('WC_Install', 'update_db_version')
            || !method_exists('WC_Install', 'get_db_update_callbacks')
            || !method_exists('WC_Admin_Notices', 'remove_notice')
        ) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'WooCommerce plugin upgrade functions not found, check for source code updates',
            );
        }

        $current_db_version = get_option('woocommerce_db_version');
        $callbacks          = WC_Install::get_db_update_callbacks();
        $callbacks_to_run   = array();

        foreach ($callbacks as $version => $update_callbacks) {
            if (version_compare($current_db_version, $version, '<')) {
                foreach ($update_callbacks as $update_callback) {
                    $callbacks_to_run[] = $update_callback;
                }
            }
        }

        if (empty($callbacks_to_run)) {
            // Ensure DB version is set to the current WC version to match WP-Admin update routine.
            WC_Install::update_db_version();

            return array(
                'success' => true,
                'message' => 'WooCommerce plugin database is already in the latest version',
            );
        }

        try {
            foreach ($callbacks_to_run as $update_callback) {
                call_user_func($update_callback);
            }
            WC_Install::update_db_version();
            WC_Admin_Notices::remove_notice('update', true);

            $success = true;
            $message = 'WooCommerce plugin database upgraded successfully';
        } catch (Exception $err) {
            $message = $err->getMessage();
        }

        return array(
            'success' => $success,
            'message' => $message
        );
    }
}
