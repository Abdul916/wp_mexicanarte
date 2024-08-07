<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_DatabaseUpdatePum extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */

    public function doTask()
    {
        $success = false;
        $message = '';

        if (!is_plugin_active('popup-maker/popup-maker.php')) {
            return array(
                'success' => true,
                'message' => 'Popup Maker plugin is not active, skipping database update'
            );
        }

        if (file_exists(WP_PLUGIN_DIR . '/popup-maker/popup-maker.php')
            && file_exists(WP_PLUGIN_DIR . '/popup-maker/includes/admin/class-pum-admin-upgrades.php')
        ) {
            include_once WP_PLUGIN_DIR . '/popup-maker/popup-maker.php';
            include_once WP_PLUGIN_DIR . '/popup-maker/includes/admin/class-pum-admin-upgrades.php';
        }

        if (!defined('POPMAKE_VERSION')) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'Popup Maker plugin not loaded'
            );
        }

        if (
            !method_exists('PUM_Admin_Upgrades', 'process_upgrades')
            || !method_exists('PUM_Admin_Upgrades', 'process_upgrades')
            ) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'Popup Maker plugin upgrade functions not found, check for source code updates',
            );
        }

        try {
            // This is the implementation of Popup Maker function process_upgrades() from:
            // https://github.com/PopupMaker/Popup-Maker/blob/30fdabe15ffc2740cb4eebed4c610e0110eb70cd/includes/admin/class-pum-admin-upgrades.php#L371

            // this is the target version that we need to reach
            $target_db_ver = Popup_Maker::$DB_VER;

            // this is the current database schema version number
            $pum_upgrades = new PUM_Admin_Upgrades;
            $current_db_ver = $pum_upgrades->get_pum_db_ver();

            if ($current_db_ver == $target_db_ver) {
                return array(
                    'success' => true,
                    'message' => 'Popup Maker database version is up to date',
                );
            }

            // Run upgrade routine until target version reached.
            while ($current_db_ver < $target_db_ver) {

                // increment the current db_ver by one
                $current_db_ver ++;

                if (file_exists(WP_PLUGIN_DIR . "/popup-maker/includes/admin/upgrades/class-pum-admin-upgrade-routine-{$current_db_ver}.php")) {

                    require_once WP_PLUGIN_DIR . "/popup-maker/includes/admin/upgrades/class-pum-admin-upgrade-routine-{$current_db_ver}.php";

                    $func = "PUM_Admin_Upgrade_Routine_{$current_db_ver}::run";
                    if (is_callable($func)) {
                        call_user_func($func);
                    }
                }
            }

            $success = true;
            $message = 'Popup Maker plugin database upgraded successfully';
        } catch (Exception $err) {
            $message = $err->getMessage();
        }

        return array(
            'success' => $success,
            'message' => $message
        );
    }
}
