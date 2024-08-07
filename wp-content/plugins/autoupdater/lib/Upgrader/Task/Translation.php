<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Upgrader_Task_Translation extends AutoUpdater_Upgrader_Task_Base
{
    /**
     * @param string $slug
     * @param string $path
     *
     * @return mixed
     */
    public function update($slug = 'translation', $path = '')
    {
        AutoUpdater_Log::debug('Starting to update translations');

        // Language_Pack_Upgrader skin was introduced in 3.7 so...
        if (version_compare(AUTOUPDATER_WP_VERSION, '3.7', '<')) {
            return true;
        }

        require_once AUTOUPDATER_LIB_PATH . 'Upgrader/Skin/Languagepack.php';

        $url = 'update-core.php?action=do-translation-upgrade';
        $nonce = 'upgrade-translations';
        $context = WP_LANG_DIR;

        ob_start();

        $this->task->upgrader = new Language_Pack_Upgrader(
            new AutoUpdater_Upgrader_Skin_Languagepack(
                compact('url', 'nonce', 'context')
            )
        );
        // don't clear update cache, so next extension's update step in same action will be able to use update cache data
        $result = $this->task->upgrader->bulk_upgrade(array(), array('clear_update_cache' => false));

        $output = ob_get_clean();
        if (!empty($output)) {
            AutoUpdater_Log::debug('Updater output: ' . $output);
        }

        // returns an array of results on success, or true if there are no updates
        if (is_array($result)) {
            $result = true;
        } elseif ($result === true) {
            $result = new WP_Error('up_to_date', 'There are no translations updates');
        }

        return $result;
    }

}
