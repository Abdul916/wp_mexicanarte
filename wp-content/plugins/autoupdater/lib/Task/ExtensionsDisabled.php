<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ExtensionsDisabled extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        AutoUpdater_Loader::loadClass('Helper_Version');
        $extensions = array();

        $list = get_plugins();
        foreach ($list as $slug => $item) {
            $extension = new stdClass();
            $extension->slug = $slug;
            $extension->type = 'plugin';

            if (!is_plugin_active($slug)) {
                $extensions[] = $extension;
            }
        }

        $current_theme = '';
        if (version_compare(AUTOUPDATER_WP_VERSION, '3.4.0', '>=')) {
            $list = array_merge($list, wp_get_themes());
            $current_theme = AutoUpdater_Helper_Version::filterHTML(wp_get_theme()->get('Name'));
        } else {
            $list = array_merge($list, get_allowed_themes()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_allowed_themesFound
            $current_theme = AutoUpdater_Helper_Version::filterHTML(get_current_theme()); // phpcs:ignore WordPress.WP.DeprecatedFunctions.get_get_current_themeFound
        }

        foreach ($list as $slug => $item) {
            $extension = new stdClass();
            $extension->slug = $slug;
            $extension->type = 'theme';

            if ($item instanceof WP_Theme && $item->name != $current_theme) {
                $extensions[] = $extension;
            }
        }

        return array(
            'success' => true,
            'extensions' => $extensions
        );
    }
}
