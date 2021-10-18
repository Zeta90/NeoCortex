<?php

/**
 * ResultModel
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class ResultModel
{
    public static array $result;

    /*
        Release the response to the client
        V1.0.0
    */
    public static function execute_request_controller()
    {
        $route_info = RouterController::get_request_route_params();
        $point = $route_info[0];
        $function = $route_info[1];

        if ($function === null) {
            $function = 'index';
        }

        $controller_file_path = CORE_ROOT_PATH . 'requests/' . $point . '.php';

        require_once($controller_file_path);

        TimerController::set_process_start_time();
        $controller_result = $point::{$function}();
        TimerController::set_process_end_time();

        if (isset($controller_result['_err'])) {
            coreErrorController::throw_coreError($controller_result['_err']);
        } else {

            $is_login_request = RouterController::is_Login();

            self::$result = $controller_result;

            if ($is_login_request === true) {
                // Defining the first account
                SessionController::set_account_login_data($controller_result);
            }
        }
    }
}

// V1.0.0