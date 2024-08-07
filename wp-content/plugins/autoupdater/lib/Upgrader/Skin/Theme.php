<?php
defined('AUTOUPDATER_LIB') or die;

if (version_compare(AUTOUPDATER_WP_VERSION, '5.3', '>=') && version_compare(PHP_VERSION, '5.6', '>=')) {
    require_once __DIR__ . '/Compatibility.php';
} else {
    class AutoUpdater_Upgrader_Skin_Theme_Compatibility extends Theme_Upgrader_Skin
    {
        public function feedback($string)
        {
            AutoUpdater_Log::debug('Upgrader feedback: ' . $string);
            $this->feedback[] = $string;
        }
    }
}

class AutoUpdater_Upgrader_Skin_Theme extends AutoUpdater_Upgrader_Skin_Theme_Compatibility
{
    /**
     * @var bool
     * @since 4.0 WordPress
     */
    public $done_footer = false;

    protected $errors = array();

    protected $feedback = array();

    public function header()
    {
        if ($this->done_header) {
            return;
        }
        $this->done_header = true;
    }

    public function footer()
    {
        if ($this->done_footer) {
            return;
        }
        $this->done_footer = true;
    }

    /**
     * Store errors instead of sending them to the feedback method
     *
     * @param string|WP_Error $errors
     */
    public function error($errors)
    {
        if (is_string($errors)) {
            $this->errors[$errors] = $message = $errors;
        } elseif (is_wp_error($errors)) {
            /** @var WP_Error $errors */
            $error_data = $errors->get_error_data();
            $message = 'Error code: ' . $errors->get_error_code() . ', message: ' . $errors->get_error_message() . (is_scalar($error_data) ? ', data: ' . $error_data : '');

            $this->errors[$errors->get_error_code()] = $errors->get_error_message() . (is_scalar($error_data) ? ' ' . $error_data : '');
        } else {
            $error = var_export($errors, true);
            $message = 'Unknown error, dump: ' . $error;

            $this->errors['unknown_error'] = $error;
        }

        AutoUpdater_Log::debug($message);
    }

    /**
     * Get all stored errors
     *
     * @return array
     */
    public function get_errors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function get_feedback()
    {
        return $this->feedback;
    }

    public function before()
    {
    }

    public function after()
    {
    }

    public function bulk_header()
    {
    }

    public function bulk_footer()
    {
    }
}
