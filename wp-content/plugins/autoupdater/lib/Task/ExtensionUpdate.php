<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ExtensionUpdate extends AutoUpdater_Task_Base
{
    protected $admin_privileges = true;
    protected $high_priority = false;

    /** @var AutoUpdater_Helper_SiteTransient */
    protected $site_transient;

    public $upgrader;
    public $old_version = '';
    public $new_version = '';
    public $expected_version = '';

    public function __construct($payload)
    {
        parent::__construct($payload);

        AutoUpdater_Loader::loadClass('Helper_SiteTransient');

        // Restore updates data if another plugin deleted it just before update
        $this->site_transient = new AutoUpdater_Helper_SiteTransient();
    }

    /**
     * @return array
     * @throws
     */
    public function doTask()
    {
        $type = strtolower($this->input('type'));
        $slug = strtolower($this->input('slug'));
        $path = $this->input('path');

        if (!$type || (!$path && !$slug && $type != 'translation')) {
            throw new AutoUpdater_Exception_Response('Nothing to update', 400);
        }

        $filemanager = AutoUpdater_Filemanager::getInstance();
        if ($path && !preg_match('!^(http|https|ftp)://!i', $path) && !$filemanager->exists($path)) {
            $path = AUTOUPDATER_SITE_PATH . $path;
            if (!$filemanager->exists($path)) {
                throw new AutoUpdater_Exception_Response('Installation path not found', 404);
            }
        }

        $this->expected_version = $this->input('version');

        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Dependencies.php';

        AutoUpdater_Loader::loadClass('Helper_Extension');
        AutoUpdater_Loader::loadClass('Helper_License');
        AutoUpdater_Loader::loadClass('Helper_Version');

        AutoUpdater_Loader::loadClass('Upgrader_Task_Base');
        $class_name = AutoUpdater_Loader::loadClass('Upgrader_Task_' . ucfirst($type));
        if ($class_name === false) {
            throw new AutoUpdater_Exception_Response('Bad type', 400);
        }

        // Convince WordPress that we're currently viewing the update-core.php page
        AutoUpdater_Helper_SiteTransient::simulateUpdateCorePage();

        /** @var AutoUpdater_Upgrader_Task_Base $upgrader_task */
        $upgrader_task = new $class_name($this);
        $result = $upgrader_task->update($slug, $path);

        $filemanager->clearPhpCache();

        return $this->getResponse($result, $slug, $type);
    }

    /**
     * @param mixed $result
     * @param string $slug
     * @param string $type
     *
     * @return array
     */
    protected function getResponse($result, $slug, $type)
    {
        $response = array(
            'success' => false,
            'message' => 'Failed to update ' . $type . ': ' . $slug,
            'extension' => array(
                'current_version' => $this->new_version,
                'expected_version' => $this->expected_version,
            ),
        );

        $errors = array();
        $feedback = array();
        if ($this->upgrader) {
            /** @var AutoUpdater_Upgrader_Skin_Core|AutoUpdater_Upgrader_Skin_Plugin|AutoUpdater_Upgrader_Skin_Theme|AutoUpdater_Upgrader_Skin_Languagepack $skin */
            $skin = $this->upgrader->skin;
            // Get all errors registered during the update process
            $errors = $skin->get_errors();
            $feedback = $skin->get_feedback();

            if ($skin instanceof AutoUpdater_Upgrader_Skin_Languagepack) {
                /** @var AutoUpdater_Upgrader_Skin_Languagepack $skin */
                $translations = $skin->get_translations();
                if (!empty($translations)) {
                    // Attach the list of installed translations
                    $response['translations'] = $translations;
                }
            }
        }

        // Add the result error to the list of all errors
        $is_result_wp_error = false;
        if (is_wp_error($result)) {
            /** @var WP_Error $result */
            $error_data = $result->get_error_data();
            $errors[$result->get_error_code()] = $result->get_error_message() . (is_scalar($error_data) ? ' ' . $error_data : '');
            $result = false;
            $is_result_wp_error = true;
        }

        if ($this->site_transient->wasSiteTransientDeleted()) {
            $errors['update_deleted'] = 'Update information was deleted by one of plugins: ' . implode(', ', $this->site_transient->getAllPluginsDeletingSiteTransient());
        }

        // Already up-to-date
        if (
            array_key_exists('up_to_date', $errors)
            // WordPress Core or Translations are already up to date
            && (in_array($type, array('core', 'translation'))
                // OR Plugin and Theme version is newer than expected
                || $this->expected_version && $this->new_version && version_compare(AutoUpdater_Helper_Version::fixAndFormat($this->expected_version), AutoUpdater_Helper_Version::fixAndFormat($this->new_version), '<='))
        ) {
            $response['success'] = true;
            $response['message'] = $errors['up_to_date'] != 'up_to_date' ? $errors['up_to_date'] : 'Up-to-date';
            unset($errors['up_to_date']);
            if (count($errors)) {
                $response['warnings'] = $errors;
            }
            return $response;
        }
        // Download package is not provided in update server response
        elseif (array_key_exists('no_package', $errors)) {
            $result = false;
            $response['error'] = array(
                'code' => 'no_package_warning',
                'message' => $errors['no_package'],
            );
            unset($errors['no_package']);
        }
        // Failed to download package from update server
        elseif (array_key_exists('download_failed', $errors)) {
            $result = false;
            $response['error'] = array(
                'code' => 'no_package_warning',
                'message' => $errors['download_failed'],
            );
            unset($errors['download_failed']);
        }
        // Failed to update Plugin and Theme
        elseif (
            $is_result_wp_error === false && in_array($type, array('plugin', 'theme')) && $this->new_version
            // New version is lower than expected
            && ($this->expected_version && version_compare(AutoUpdater_Helper_Version::fixAndFormat($this->expected_version), AutoUpdater_Helper_Version::fixAndFormat($this->new_version), '>')
                // Version did not change
                || !$this->expected_version && version_compare(AutoUpdater_Helper_Version::fixAndFormat($this->old_version), AutoUpdater_Helper_Version::fixAndFormat($this->new_version), '='))
        ) {
            $result = false;
            $response['error'] = array(
                'code' => 'no_update_warning',
                'message' => 'No update was performed, current version: ' . $this->new_version
                    . ', expected version: ' . $this->expected_version,
            );
        }

        // Update succeeded
        if ($result === true || (is_null($result) && !isset($response['error']) && !count($errors))) {
            $response['success'] = true;
            unset($response['message']);
            if (count($errors)) {
                $response['warnings'] = $errors;
            }
            return $response;
        }
        // Unknown result
        elseif (!is_null($result) && !is_bool($result)) {
            $errors['unknown_error'] = 'Result dump: ' . var_export($result, true);
        }

        // Did the update fail because of a missing valid license key?
        if ($response['success'] === false && in_array($type, array('plugin', 'theme')) && !AutoUpdater_Helper_License::hasValidLicense($slug)) {
            $errors['invalid_license'] = 'Missing a valid license key';
        }

        // There are some more errors
        if (count($errors)) {
            // Set the main error
            if (!isset($response['error'])) {
                end($errors);
                $response['error'] = array(
                    'code' => key($errors),
                    'message' => current($errors),
                );
                unset($errors[$response['error']['code']]);
            }
            // Additional errors
            if (count($errors)) {
                $response['errors'] = $errors;
            }
        }

        if (count($feedback)) {
            $response['run_sequence'] = $feedback;
        }

        global $wp_filesystem;
        $response['filesystem_method'] = $wp_filesystem->method;

        return $response;
    }
}
