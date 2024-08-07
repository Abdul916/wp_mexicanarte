<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Skin_Compatibility
{
}

if (version_compare(PHP_VERSION, '5.6', '>=')) {

    class AutoUpdater_Upgrader_Skin_Core_Compatibility extends WP_Upgrader_Skin
    {
        public function feedback($string, ...$args) // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs
        {
            AutoUpdater_Log::debug('Upgrader feedback: ' . $string);
            $this->feedback[] = $string;
        }
    }

    class AutoUpdater_Upgrader_Skin_Plugin_Compatibility extends Plugin_Upgrader_Skin
    {
        public function feedback($string, ...$args) // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs
        {
            AutoUpdater_Log::debug('Upgrader feedback: ' . $string);
            $this->feedback[] = $string;
        }
    }

    class AutoUpdater_Upgrader_Skin_Theme_Compatibility extends Theme_Upgrader_Skin
    {
        public function feedback($string, ...$args) // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs
        {
            AutoUpdater_Log::debug('Upgrader feedback: ' . $string);
            $this->feedback[] = $string;
        }
    }

    class AutoUpdater_Upgrader_Skin_Languagepack_Compatibility extends Language_Pack_Upgrader_Skin
    {
        public function feedback($string, ...$args) // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs
        {
            AutoUpdater_Log::debug('Upgrader feedback: ' . $string);
            $this->feedback[] = $string;
        }
    }
}
