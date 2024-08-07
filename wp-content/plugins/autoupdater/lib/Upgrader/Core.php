<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Core extends Core_Upgrader
{
    /**
     * Unpack a compressed package file.
     *
     * @since  2.8.0
     * @access public
     *
     * @global WP_Filesystem_Base $wp_filesystem  Subclass
     *
     * @param string              $package        Full path to the package file.
     * @param bool                $delete_package Optional. Whether to delete the package file after attempting
     *                                            to unpack it. Default true.
     *
     * @return string|WP_Error The path to the unpacked contents, or a WP_Error on failure.
     */
    public function unpack_package($package, $delete_package = true)
    {
        global $wp_filesystem;

        // Do not unpack if it is already done
        if ($wp_filesystem->is_dir($package)) {
            return $package;
        }

        return parent::unpack_package($package, $delete_package);
    }
}
