<?php

require_once 'core/models/session/sanitizer/sanitizeSignupModel.php';

class Signup
{

    public static function index()
    {
        $appID = NeoCortexAppController::_get('ID');

        $signup_result = new stdClass();
        $signup_result->success = false;

        $in_signup_data = sanitizeSignupModel::sanitize_signup_application();

        array_push($in_signup_data, $appID);

        $mysql = databasesController::mysqlDB();
        $result = $mysql->execute_SP(SP_API_SIGNUP_APPLICATION, $in_signup_data);

        return $result;
    }

    public static function finish()
    {
        $appID = NeoCortexAppController::_get('ID');

        $signup_result = new stdClass();
        $signup_result->success = false;

        $in_signup_data = sanitizeSignupModel::sanitize_signup_account();

        $route_params = RouterController::get_request_route_params();

        array_push($in_signup_data, $route_params[2], $appID);

        $mysql = databasesController::mysqlDB();
        $result = $mysql->execute_SP(SP_API_SIGNUP_ACCOUNT, $in_signup_data);

        if (!isset($result['_err'])) {
            return $result;
        } else {
            return $result['_err'];
        }
    }
}
