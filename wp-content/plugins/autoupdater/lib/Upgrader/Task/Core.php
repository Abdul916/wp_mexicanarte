<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Task_Core extends AutoUpdater_Upgrader_Task_Base
{
    /**
     * @param string $slug
     * @param string $path
     *
     * @return mixed
     */
    public function update($slug = 'core', $path = '')
    {
        AutoUpdater_Log::debug('Starting to update WordPress');

        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Core.php';
        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Skin/Core.php';

        $wp_upgrade_dir = WP_CONTENT_DIR . '/upgrade';
        $filemanager = AutoUpdater_Filemanager::getInstance();
        if (!$filemanager->is_dir($wp_upgrade_dir)) {
            $filemanager->mkdir($wp_upgrade_dir);
        }

        $expected_version = $this->task->expected_version;
        if (empty($expected_version)) {
            $expected_version = AUTOUPDATER_WP_VERSION;
        }
        if (substr($expected_version, -2) == '.0') {
            // Remove the last zero from the version X.Y.0
            $expected_version = substr($expected_version, 0, -2);
        }
        $this->task->expected_version = $expected_version;

        $working_dir = $path;
        $update = (object) array(
            'response' => 'upgrade',
            'download' => $working_dir,
            'locale' => 'en_US',
            'package' => $working_dir,
            /** @since 3.2.0 */
            'packages' => (object) array(
                'full' => false,
                'no_content' => $working_dir,
                'new_bundled' => false,
                'partial' => false,
                'rollback' => false,
            ),
            'current' => $expected_version,
            'version' => $expected_version,
            'php_version' => '5.2.4',
            'mysql_version' => '5.0',
            'new_bundled' => false,
            'partial_version' => false,
        );

        ob_start();

        $this->task->upgrader = new AutoUpdater_Upgrader_Core(
            new AutoUpdater_Upgrader_Skin_Core()
        );
        $result = $this->task->upgrader->upgrade($update, array('pre_check_md5' => false));

        $output = ob_get_clean();
        if (!empty($output)) {
            AutoUpdater_Log::debug('Updater output: ' . $output);
        }

        // returns string with a new version or null on success
        if (is_string($result) && preg_match('/^\d+(\.\d+)+/', $result)) {
            /** @since 3.3.0 */
            // Check if the version after update is the same or higher than expected
            if (version_compare(AutoUpdater_Helper_Version::fixAndFormat($expected_version), AutoUpdater_Helper_Version::fixAndFormat($result), '<=')) {
                $result = new WP_Error('wrong_version', sprintf('Expected version: %s, current version: %s', $expected_version, $result));
            }
        }

        return $result;
    }
}
