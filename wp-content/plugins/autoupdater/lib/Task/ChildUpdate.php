<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ChildUpdate extends AutoUpdater_Task_Base
{
    protected $encrypt = false;

    /** @var AutoUpdater_Request */
    protected $request;

    /**
     * @return array
     */
    public function doTask()
    {
        $query = array(
            'provider' => $this->input('provider', 'wpengine')
        );
        $site_id = $this->input('site_id');

        $this->request = AutoUpdater_Request::api('GET', 'sites/download/worker.zip', $query, '', $site_id);
        add_filter('http_request_args', array($this, 'addDownloadRequestHeaders'), 10, 2);

        $this->setInput('type', 'plugin');
        $this->setInput('slug', AUTOUPDATER_WP_PLUGIN_SLUG);
        $this->setInput('path', $this->request->getUrl());

        /** @see AutoUpdater_Task_ExtensionUpdate::doTask() */
        return AutoUpdater_Task::getInstance('ExtensionUpdate', $this->payload)
            ->doTask();
    }

    /**
     * @param array  $parsed_args An array of HTTP request arguments.
     * @param string $url         The request URL.
     *
     * @return array $parsed_args
     */
    public function addDownloadRequestHeaders($parsed_args = array(), $url = '')
    {
        if (strpos($url, $this->request->url) === 0 && isset($parsed_args['headers']) && is_array($parsed_args['headers'])) {
            $parsed_args['headers'] = array_merge($parsed_args['headers'], $this->request->headers);
        }

        return $parsed_args;
    }
}
