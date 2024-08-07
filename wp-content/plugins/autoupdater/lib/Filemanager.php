<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Filemanager
{
    protected static $instance = null;

    protected $FS_CHMOD_FILE;
    protected $FS_CHMOD_DIR;
    protected static $wp_filesystem;

    public function __construct()
    {
        $this->FS_CHMOD_DIR = (fileperms(AUTOUPDATER_SITE_PATH) & 0777 | 0755);

        if (file_exists(AUTOUPDATER_SITE_PATH . 'index.php')) {
            $this->FS_CHMOD_FILE = (fileperms(AUTOUPDATER_SITE_PATH . 'index.php') & 0777 | 0644);
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';
        if (function_exists('WP_Filesystem') and WP_Filesystem()) {
            global $wp_filesystem;

            static::$wp_filesystem = $wp_filesystem;
        }

        add_filter('file_mod_allowed', 'AutoUpdater_Filemanager::filter_file_mod_allowed');
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (!is_null(static::$instance)) {
            return static::$instance;
        }

        $class_name = AutoUpdater_Loader::loadClass('Filemanager');

        static::$instance = new $class_name();

        return static::$instance;
    }

    /**
     * Filters whether file modifications are allowed.
     *
     * @since WP 4.8.0
     *
     * @param bool   $file_mod_allowed Whether file modifications are allowed.
     * @param string $context          The usage context.
     */
    public static function filter_file_mod_allowed($file_mod_allowed = true, $context = '')
    {
        return true;
    }

    /**
     * Reads entire file into a string
     *
     * @access public
     *
     * @param string $file Name of the file to read.
     *
     * @return string|bool The function returns the read data or false on failure.
     */
    public function get_contents($file)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->get_contents($file);
        }

        return @file_get_contents($file); // phpcs:ignore
    }

    /**
     * Write a string to a file
     *
     * @access public
     *
     * @param string $file     Remote path to the file where to write the data.
     * @param string $contents The data to write.
     * @param int $flags
     *
     * @return bool False upon failure, true otherwise.
     */
    public function put_contents($file, $contents, $flags = 0)
    {
        return @file_put_contents($file, $contents, $flags) !== false; // phpcs:ignore
    }

    /**
     * Changes file group
     *
     * @access public
     *
     * @param string $file      Path to the file.
     * @param mixed  $group     A group name or number.
     * @param bool   $recursive Optional. If set True changes file group recursively. Default false.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chgrp($file, $group, $recursive = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->chgrp($file, $group, $recursive);
        }

        if (!$this->exists($file)) {
            return false;
        }

        if (!$recursive) {
            return @chgrp($file, $group); // phpcs:ignore
        }

        if (!$this->is_dir($file)) {
            return @chgrp($file, $group); // phpcs:ignore
        }

        // Is a directory, and we want recursive
        $file = $this->trailingslashit($file);
        $filelist = $this->dirlist($file);
        foreach ($filelist as $filename => $fileinfo) {
            $this->chgrp($file . $filename, $group, $recursive);
        }

        return true;
    }

    /**
     * Changes filesystem permissions
     *
     * @access public
     *
     * @param string $file      Path to the file.
     * @param int    $mode      Optional. The permissions as octal number, usually 0644 for files,
     *                          0755 for dirs. Default false.
     * @param bool   $recursive Optional. If set True changes file group recursively. Default false.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chmod($file, $mode = false, $recursive = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->chmod($file, $mode, $recursive);
        }

        if (!$mode) {
            if ($this->is_file($file)) {
                $mode = $this->FS_CHMOD_FILE;
            } elseif ($this->is_dir($file)) {
                $mode = $this->FS_CHMOD_DIR;
            } else {
                return false;
            }
        }

        if (!$recursive || !$this->is_dir($file)) {
            return @chmod($file, $mode); // phpcs:ignore
        }

        // Is a directory, and we want recursive
        $file = $this->trailingslashit($file);
        $filelist = $this->dirlist($file);
        foreach ((array) $filelist as $filename => $fileinfo) {
            $this->chmod($file . $filename, $mode, $recursive);
        }

        return true;
    }

    /**
     * Changes file owner
     *
     * @access public
     *
     * @param string $file      Path to the file.
     * @param mixed  $owner     A user name or number.
     * @param bool   $recursive Optional. If set True changes file owner recursively.
     *                          Default false.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function chown($file, $owner, $recursive = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->chown($file, $owner, $recursive);
        }

        if (!$this->exists($file)) {
            return false;
        }

        if (!$recursive) {
            return @chown($file, $owner); // phpcs:ignore
        }

        if (!$this->is_dir($file)) {
            return @chown($file, $owner); // phpcs:ignore
        }

        // Is a directory, and we want recursive
        $filelist = $this->dirlist($file);
        foreach ($filelist as $filename => $fileinfo) {
            $this->chown($file . '/' . $filename, $owner, $recursive);
        }

        return true;
    }

    /**
     * @access public
     *
     * @param string $source
     * @param string $destination
     * @param bool   $overwrite
     * @param int    $mode
     *
     * @return bool
     */
    public function copy($source, $destination, $overwrite = false, $mode = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->copy($source, $destination, $overwrite, $mode);
        }

        if (!$overwrite && $this->exists($destination)) {
            return false;
        }

        $rtval = copy($source, $destination); // phpcs:ignore
        if ($mode) {
            $this->chmod($destination, $mode);
        }

        return $rtval;
    }

    /**
     * @access public
     *
     * @param string $source
     * @param string $destination
     * @param bool   $overwrite
     *
     * @return bool
     */
    public function move($source, $destination, $overwrite = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->move($source, $destination, $overwrite);
        }

        if (!$overwrite && $this->exists($destination)) {
            return false;
        }

        // Try using rename first. if that fails (for example, source is read only) try copy.
        if (@rename($source, $destination)) { // phpcs:ignore
            return true;
        }

        if ($this->copy($source, $destination, $overwrite) && $this->exists($destination)) {
            $this->delete($source);

            return true;
        } else {
            return false;
        }
    }

    /**
     * @access public
     *
     * @param string $file
     * @param bool   $recursive
     * @param string $type
     *
     * @return bool
     */
    public function delete($file, $recursive = false, $type = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->delete($file, $recursive, $type);
        }

        if (empty($file)) // Some filesystems report this as /, which can cause non-expected recursive deletion of all files in the filesystem.
        {
            return false;
        }

        $file = str_replace('\\', '/', $file); // for win32, occasional problems deleting files otherwise

        if ('f' == $type || $this->is_file($file)) {
            return @unlink($file); // phpcs:ignore
        }

        if (!$recursive && $this->is_dir($file)) {
            return @rmdir($file); // phpcs:ignore
        }

        // At this point it's a folder, and we're in recursive mode
        $file = $this->trailingslashit($file);
        $filelist = $this->dirlist($file, true);

        $retval = true;
        if (is_array($filelist)) {
            foreach ($filelist as $filename => $fileinfo) {
                if (!$this->delete($file . $filename, $recursive, $fileinfo['type'])) {
                    $retval = false;
                }
            }
        }

        if (file_exists($file) && !@rmdir($file)) { // phpcs:ignore
            $retval = false;
        }

        return $retval;
    }

    /**
     * @access public
     *
     * @param string $file
     *
     * @return bool
     */
    public function exists($file)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->exists($file);
        }

        return @file_exists($file);
    }

    /**
     * @access public
     *
     * @param string $file
     *
     * @return bool
     */
    public function is_file($file)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->is_file($file);
        }

        return @is_file($file);
    }

    /**
     * @access public
     *
     * @param string $path
     *
     * @return bool
     */
    public function is_dir($path)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->is_dir($path);
        }

        return @is_dir($path);
    }

    /**
     * @access public
     *
     * @param string $file
     *
     * @return bool
     */
    public function is_readable($file)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->is_readable($file);
        }

        return @is_readable($file);
    }

    /**
     * @access public
     *
     * @param string $file
     *
     * @return bool
     */
    public function is_writable($file)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->is_writable($file);
        }

        return @is_writable($file); // phpcs:ignore
    }

    /**
     * @access public
     *
     * @param string $path
     * @param mixed  $chmod
     * @param mixed  $chown
     * @param mixed  $chgrp
     *
     * @return bool
     */
    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->mkdir($path, $chmod, $chown, $chgrp);
        }

        // Safe mode fails with a trailing slash under certain PHP versions.
        $path = $this->untrailingslashit($path);
        if (empty($path)) {
            return false;
        }

        if (!$chmod) {
            $chmod = $this->FS_CHMOD_DIR;
        }

        if (!@mkdir($path)) { // phpcs:ignore
            return false;
        }

        $this->chmod($path, $chmod);
        if ($chown) {
            $this->chown($path, $chown);
        }

        if ($chgrp) {
            $this->chgrp($path, $chgrp);
        }

        return true;
    }

    /**
     * @param string      $url
     * @param string|null $destination Destination file name
     *
     * @return bool|string Path on success, FALSE on failure
     * @throws Exception
     */
    public function download($url, $destination = null)
    {
        $result = download_url($url);
        if (is_wp_error($result)) {
            /** @var WP_Error $result */
            $e = new AutoUpdater_Exception_Response('Failed to download file from URL: ' . $url, 200);
            $e->setError($result->get_error_code(), $result->get_error_message());
            throw $e;
        }

        if ($destination) {
            $this->move($result, $destination);

            return $destination;
        }

        return $result;
    }

    /**
     * @param string      $file
     * @param string|null $destination
     *
     * @return string Path on success
     * @throws Exception
     */
    public function unpack($file, $destination = null)
    {
        // WordPress will create destination directory if it does not exist
        if ($destination) {
            $path = $destination;
        } else {
            $path = dirname($file) . '/' . $this->getRandomName() . '/';
        }

        $result = unzip_file($file, $path);

        if (is_wp_error($result)) {
            /** @var WP_Error $result */
            $e = new AutoUpdater_Exception_Response('Failed to unpack file: ' . basename($file), 200);
            $e->setError($result->get_error_code(), $result->get_error_message());
            throw $e;
        }

        return $path;
    }

    /**
     * @return bool
     */
    public function setTempDirWithinSite()
    {
        if (defined('WP_TEMP_DIR') && strpos(realpath(WP_TEMP_DIR), realpath(AUTOUPDATER_SITE_PATH)) === false) {
            AutoUpdater_Log::error(sprintf('WP_TEMP_DIR is defined and it points to a location outside of the site: %s', WP_TEMP_DIR));
            return false;
        }

        if (!defined('WP_TEMP_DIR')) {
            define('WP_TEMP_DIR', WP_CONTENT_DIR . '/upgrade');
        }

        if (!$this->exists(WP_TEMP_DIR) && !$this->mkdir(WP_TEMP_DIR, 0700)) {
            AutoUpdater_Log::error(sprintf('Failed to create the directory: %s', WP_TEMP_DIR));
            return false;
        }

        if (!$this->is_writable(WP_TEMP_DIR) && !$this->chmod(WP_TEMP_DIR, 0700)) {
            AutoUpdater_Log::error(sprintf('Failed to set write permission to the directory: %s', WP_TEMP_DIR));
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getTempPath()
    {
        return get_temp_dir();
    }

    /**
     * @return string
     */
    public function getRandomName()
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes(8)); //2 characters per byte = 16 chars
        } else {
            //Eh, we gotta make do somehow
            return substr(str_shuffle(MD5(microtime())), 0, 16);
        }
    }

    public function clearPhpCache()
    {
        // Make sure that PHP has the latest data of the files.
        @clearstatcache();

        // Remove all compiled files from opcode cache.
        if (function_exists('opcache_reset')) {
            // Always reset the OPcache if it's enabled. Otherwise there's a good chance the server will not know we are
            // replacing .php scripts. This is a major concern since PHP 5.5 included and enabled OPcache by default.
            @opcache_reset(); // phpcs:ignore PHPCompatibility.FunctionUse.NewFunctions
        } elseif (function_exists('apc_clear_cache')) {
            @apc_clear_cache(); // phpcs:ignore
        }
    }

    /**
     * @access public
     *
     * @param string $path
     * @param bool   $include_hidden
     * @param bool   $recursive
     *
     * @return bool|array
     */
    public function dirlist($path, $include_hidden = true, $recursive = false)
    {
        if (static::$wp_filesystem) {
            return static::$wp_filesystem->dirlist($path, $include_hidden, $recursive);
        }

        if ($this->is_file($path)) {
            $limit_file = basename($path);
            $path = dirname($path);
        } else {
            $limit_file = false;
        }

        if (!$this->is_dir($path)) {
            return false;
        }

        $dir = @dir($path);
        if (!$dir) {
            return false;
        }

        $ret = array();

        while (false !== ($entry = $dir->read())) {
            $struc = array();
            $struc['name'] = $entry;

            if ('.' == $struc['name'] || '..' == $struc['name']) {
                continue;
            }

            if (!$include_hidden && '.' == $struc['name'][0]) {
                continue;
            }

            if ($limit_file && $struc['name'] != $limit_file) {
                continue;
            }

            $struc['type'] = $this->is_dir($path . '/' . $entry) ? 'd' : 'f';

            if ('d' == $struc['type']) {
                if ($recursive) {
                    $struc['files'] = $this->dirlist($path . '/' . $struc['name'], $include_hidden, $recursive);
                } else {
                    $struc['files'] = array();
                }
            }

            $ret[$struc['name']] = $struc;
        }
        $dir->close();
        unset($dir);

        return $ret;
    }

    /**
     * Appends a trailing slash.
     *
     * Will remove trailing forward and backslashes if it exists already before adding
     * a trailing forward slash. This prevents double slashing a string or path.
     *
     * @param string $string What to add the trailing slash to.
     *
     * @return string String with trailing slash added.
     */
    public function trailingslashit($string)
    {
        return $this->untrailingslashit($string) . '/';
    }

    /**
     * Removes trailing forward slashes and backslashes if they exist.
     *
     * @param string $string What to remove the trailing slashes from.
     *
     * @return string String without the trailing slashes.
     */
    public function untrailingslashit($string)
    {
        return rtrim($string, '/\\');
    }

    /**
     * Trims the path to site's root from a given path (i.e. replaces the left-most occurrence of it).
     *
     * @param string $path
     *
     * @return string
     */
    public function trimPath($path)
    {
        // Only replace the site's path from the beginning of the path to the file list
        // this makes sure that if the site's chrooted (i.e. AUTOUPDATER_SITE_PATH === '/')
        // we'll not replace every '/' in the string
        if (substr($path, 0, strlen(AUTOUPDATER_SITE_PATH)) === AUTOUPDATER_SITE_PATH) {
            $path = substr($path, strlen(AUTOUPDATER_SITE_PATH));
        }

        return $path;
    }
}
