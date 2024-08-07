<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_ChildToken extends AutoUpdater_Task_Base
{
    /**
     * @return array
     */
    public function doTask()
    {
        $token = $this->getToken();;
        if (empty($token)) {
            throw AutoUpdater_Exception_Response::getException(
                404,
                'Failed to get the token',
                'wpe_apikey_missing',
                'Missing WPE_APIKEY in the install.'
            );
        }

        return array(
            'success' => true,
            'token' => $token,
        );
    }

    /**
     * @return string
     */
    public function getToken()
    {
        if (!defined('WPE_APIKEY') || !WPE_APIKEY) {
            return '';
        }
        $payload = 'ausal_dotywpg|e_th_';
        $keys = array(array(10, 2), array(14, 2), array(0, 2), array(16, 3), array(2, 3), array(8, 2), array(5, 3), array(12, 2));
        return md5(implode('', array_map(function ($a) use ($payload) {
            return substr($payload, $a[0], $a[1]);
        }, $keys)) . WPE_APIKEY);
    }
}
