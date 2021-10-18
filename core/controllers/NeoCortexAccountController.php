<?php

/**
 * NeoCortexAccountController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

require_once 'core/models/session/NeoCortexAccountModel.php';

class NeoCortexAccountController
{
    private NeoCortexAccountModel $account;

    /*
        Release the response to the client
    */
    public static function set_account()
    {
        if (!isset(self::$account)) {
            self::$account = new NeoCortexAccountModel();
        }

        $account = &self::$account;
        return $account;
    }
}