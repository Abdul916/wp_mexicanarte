<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ChildWhitelabelling extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $name = $this->input('name');
        $author = $this->input('author');
        $child_page = $this->input('child_page');
        $protect_child = (int) $this->input('protect_child', 1);
        $hide_child = (int) $this->input('hide_child');

        if (empty($name)) {
            AutoUpdater_Config::remove('whitelabel_name');
        } else {
            AutoUpdater_Config::set('whitelabel_name', $name);
        }

        if (empty($author)) {
            AutoUpdater_Config::remove('whitelabel_author');
        } else {
            AutoUpdater_Config::set('whitelabel_author', $author);
        }

        if (empty($child_page)) {
            AutoUpdater_Config::remove('whitelabel_child_page');
        } else {
            AutoUpdater_Config::set('whitelabel_child_page', $child_page);
        }

        AutoUpdater_Config::set('protect_child', $protect_child);
        AutoUpdater_Config::set('hide_child', $hide_child);

        return array(
            'success' => true,
        );
    }
}
