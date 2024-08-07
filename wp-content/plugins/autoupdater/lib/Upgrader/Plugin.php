<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Plugin extends Plugin_Upgrader
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

    /**
     * Run an upgrade/install.
     *
     * Attempts to download the package (if it is not a local file), unpack it, and
     * install it in the destination folder.
     *
     * @since  2.8.0
     * @access public
     *
     * @param array $options                     {
     *                                           Array or string of arguments for upgrading/installing a package.
     *
     * @type string $package                     The full path or URI of the package to install.
     *                                               Default empty.
     * @type string $destination                 The full path to the destination folder.
     *                                               Default empty.
     * @type bool   $clear_destination           Whether to delete any files already in the
     *                                               destination folder. Default false.
     * @type bool   $clear_working               Whether to delete the files form the working
     *                                               directory after copying to the destination.
     *                                               Default false.
     * @type bool   $abort_if_destination_exists Whether to abort the installation if the destination
     *                                               folder already exists. When true, `$clear_destination`
     *                                               should be false. Default true.
     * @type bool   $is_multi                    Whether this run is one of multiple upgrade/install
     *                                               actions being performed in bulk. When true, the skin
     *                                               WP_Upgrader::header() and WP_Upgrader::footer()
     *                                               aren't called. Default false.
     * @type array  $hook_extra                  Extra arguments to pass to the filter hooks called by
     *                                               WP_Upgrader::run().
     * }
     * @return array|false|WP_error The result from self::install_package() on success, otherwise a WP_Error,
     *                              or false if unable to connect to the filesystem.
     */
    public function run($options)
    {
        /** @since 3.6.0 */
        $options['abort_if_destination_exists'] = false;
        $options['clear_destination'] = true;

        return parent::run($options);
    }
}
