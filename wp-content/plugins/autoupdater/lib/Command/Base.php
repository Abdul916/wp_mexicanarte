<?php
defined('AUTOUPDATER_LIB') or die;

/**
 * @see https://make.wordpress.org/cli/handbook/commands-cookbook/
 */
abstract class AutoUpdater_Command_Base
{
    /**
     * @var array
     */
    protected $bool_options = array();

    /**
     * @var array
     */
    protected $int_options = array();

    /**
     * @var array
     */
    protected $null_options = array();

    /**
     * @var array
     */
    protected $array_options = array();

    /**
     * @param array $args
     * @param array $assoc_args
     *
     * @return void
     */
    abstract public function __invoke($args, $assoc_args);

    /**
     * @return void
     */
    abstract public static function beforeInvoke();

    /**
     * @param array $assoc_args
     *
     * @return bool
     */
    protected function validateBoolOptions($assoc_args)
    {
        $result = true;
        foreach ($this->bool_options as $option) {
            if (isset($assoc_args[$option]) && !$this->isBool($assoc_args[$option])) {
                WP_CLI::error(sprintf('The value of --%s option is invalid. Provide 0 or 1.', $option), false);
                $result = false;
            }
        }
        return $result;
    }

    /**
     * @param array $assoc_args
     *
     * @return bool
     */
    protected function validateIntOptions($assoc_args)
    {
        $result = true;
        foreach ($this->int_options as $option) {
            if (isset($assoc_args[$option]) && !is_numeric($assoc_args[$option])) {
                WP_CLI::error(sprintf('The value of --%s option is invalid. Provide a number.', $option), false);
                $result = false;
            }
        }
        return $result;
    }

    /**
     * @param string $option
     * @param mixed $value
     *
     * @return mixed
     */
    protected function castOptionValue($option, $value)
    {
        if (in_array($option, $this->bool_options)) {
            return is_bool($value) ? $value : $this->castBool($value);
        }

        if (in_array($option, $this->null_options)) {
            if (!$value || strtolower($value) === 'null') {
                return null;
            }
        }

        if (in_array($option, $this->string_options)) {
            if ($value === null) {
                return '';
            }
            return (string) $value;
        }

        if (in_array($option, $this->int_options)) {
            return intval($value);
        }

        if (in_array($option, $this->array_options)) {
            return $this->castArray($value);
        }

        return $value;
    }

    /**
     * @param string $value
     *
     * @return array
     */
    protected function castArray($value)
    {
        if (is_array($value)) {
            return $value;
        }
        if (empty($value)) {
            return array();
        }
        return array_map('trim', explode(',', $value));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function castBool($value)
    {
        return $this->isTrue($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isBool($value)
    {
        return $this->isTrue($value) || $this->isFalse($value);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isTrue($value)
    {
        return in_array(strtolower($value), array('y', 'yes', 'on', 'true', '1'));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isFalse($value)
    {
        return in_array(strtolower($value), array('n', 'no', 'off', 'false', '0'));
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isDate($value)
    {
        return !!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);
    }
}
