<?php

/**
 * sAuth
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class sAuth
{
    /**
     * Executes the auth system
     * V1.0.0
     */
    public static function exAuth($app_data, $auth_data)
    {
        $app_target_token = $app_data['authToken'];

        if ($app_target_token !== $auth_data) {
            // V1.0.0
            return 'ERR_NEOCORTEX_APP_AUTH_SAUTH_TOKEN_FAILED';
        }

        return true;
    }
}
