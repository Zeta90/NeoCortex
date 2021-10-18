<?php

/**
 * Request Controller: Login
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

require_once 'core/models/session/sanitizer/sanitizeLoginModel.php';

class Login
{
    /*
        Execute the Login process
        V1.0.0
    */
    public static function index()
    {
        $appID = NeoCortexAppController::_get('ID');

        $login_result = new stdClass();
        $login_result->success = false;

        $in_login_data = sanitizeLoginModel::sanitize_login_data();

        array_push($in_login_data, $appID);
        array_push($in_login_data, 0);

        $mysql = databasesController::mysqlDB();
        $result = $mysql->execute_SP(SP_API_LOGIN_ACCOUNT, $in_login_data);

        return $result;
    }
}
