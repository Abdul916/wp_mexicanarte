<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_MultisiteUrls extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        return array(
            'success' => true,
            'urls' => $this->getUrls()
        );
    }

    protected function getUrls()
    {
        $urls = array();

        if (!is_multisite()) {
            return $urls;
        }

        if (version_compare(AUTOUPDATER_WP_VERSION, '4.6', '>=') && function_exists('get_sites')) {
            $sites = get_sites(array(
                'number' => 1000,
                'fields' => 'ids',
                'archived' => 0,
                'deleted' => 0
            ));
            foreach ($sites as $id) {
                $urls[] = rtrim(get_home_url($id), '/');
            }
        } elseif (version_compare(AUTOUPDATER_WP_VERSION, '3.7', '>=') && function_exists('wp_get_sites')) {
            $sites = wp_get_sites(array( // phpcs:ignore WordPress.WP.DeprecatedFunctions.wp_get_sitesFound
                'limit' => 1000,
                'archived' => 0,
                'deleted' => 0
            ));
            foreach ($sites as $site) {
                $urls[] = rtrim(get_home_url($site['blog_id']), '/');
            }
        }

        return $urls;
    }
}
