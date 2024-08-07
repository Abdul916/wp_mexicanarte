<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Selfupdate extends AutoUpdater_Command_Base
{
    /**
     * AutoUpdater WordPress plugin self-update
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        $current_version = AUTOUPDATER_VERSION;
        WP_CLI::line(sprintf('Updating %s %s ...', AUTOUPDATER_WP_PLUGIN_NAME, $current_version));

        try {
            /** @var AutoUpdater_Task_ChildUpdate $task */
            $task = AutoUpdater_Task::getInstance('ChildUpdate');
            $result = $task->doTask();
        } catch (AutoUpdater_Exception_Response $e) {
            if ($e->getErrorCode()) {
                WP_CLI::error(sprintf('Failed to update plugin. Error [%s] %s', $e->getErrorCode(), $e->getErrorMessage()));
                return;
            }
            WP_CLI::error(sprintf('Failed to update plugin. Error [%s] %s', $e->getCode(), $e->getMessage()));
            return;
        } catch (Exception $e) {
            WP_CLI::error(sprintf('Failed to update plugin. Error [%s] %s', $e->getCode(), $e->getMessage()));
            return;
        }

        $installer = AutoUpdater_Installer::getInstance();
        $new_version = $installer->getVersion();

        if ($new_version && version_compare($current_version, $new_version, '>=') && (!empty($result['success']) || $result['error']['code'] === 'no_update_warning')) {
            WP_CLI::success('Plugin is already up-to-date.');
            return;
        }

        if (empty($result['success'])) {
            WP_CLI::error(sprintf('Failed to update plugin. Error [%s] %s', $result['error']['code'], $result['error']['message']));
            return;
        }

        if (!$installer->update()) {
            WP_CLI::error(sprintf('Failed to run post-update process after updating to version %s. Try again!', $new_version));
            return;
        }

        WP_CLI::success(sprintf('Plugin has been successfully update to version %s', $new_version));
    }

    public static function beforeInvoke()
    {
    }
}
