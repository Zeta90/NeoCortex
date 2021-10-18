<?php

/**
 * RouterController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class RouterController
{
    /*
        Validates route input
        V1.0.0
    */
    public static function validate_route()
    {
        if (isset($_GET["ncortex"])) {
            $route_info = self::get_request_route_params();
            $point = $route_info[0];
            $function = $route_info[1];

            if ($function === null) {
                $function = 'index';
            }

            // Get Route Info
            $point = $route_info[0];

            $json_route_file_path = CORE_ROOT_PATH . ROUTES_JSON_FILE;
            $routes_content = file_get_contents($json_route_file_path);
            $routes = json_decode($routes_content);

            $route_info = null;
            $function_info = null;

            foreach ($routes as $name => $info) {
                if ($name === $point) {
                    $route_info =  $info;
                }
            }

            if ($route_info === null) {
                // V1.0.0
                coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_NOT_LISTED');
            }

            foreach ($route_info->get_functions as $func => $func_info) {
                if ($function === $func) {
                    $function_info = $func_info;
                }
            }

            if ($function_info === null) {
                // V1.0.0
                coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_GET_FUNCTION_NOT_LISTED');
            }

            // Public requested route is available by config
            if ($route_info->public === true) {

                if ($point === 'login') {
                    $availability = get_defined_constants(true)['user']['API_LOGIN_ALLOWED'];

                    if ($availability === false) {
                        // V1.0.0
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_LOGIN_DISABLED');
                    }
                } elseif ($point === 'signup') {
                    $availability = get_defined_constants(true)['user']['API_SIGNUP_ALLOWED'];

                    if ($availability === false) {
                        // V1.0.0
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_LOGIN_DISABLED');
                    }
                }
            }

            // Requested method allowed
            $route_allowed_method = $function_info->allowed_HTTP_method;
            if ($route_allowed_method !== $_SERVER["REQUEST_METHOD"]) {
                // V1.0.0
                coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_METHOD_FORBIDDEN');
            }

            if (isset($function_info->required_HTTP_headers) && is_array($function_info->required_HTTP_headers)) {
                $route_headers = $function_info->required_HTTP_headers;

                // Required headers 
                foreach ($route_headers as $header) {
                    if (!isset($_SERVER[$header])) {
                        // V1.0.0
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_HEADERS_REQUIRED_NOT_FOUND');
                    }
                }
            }

            if (isset($function_info->required_POST_params) && is_array($function_info->required_POST_params)) {
                $route_post_params = $function_info->required_POST_params;

                // Required POST params
                foreach ($route_post_params as $post_param) {
                    if (!isset($_POST[$post_param])) {
                        // V1.0.0
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_POST_PARAMS_REQUIRED_NOT_FOUND');
                    }
                }
            }

            if (isset($route_info->required_GET_params)) {
                $get_len = sizeof($route_info->required_GET_params);
                $get_route_gets = $route_info[2];

                if ($get_len != 0) {
                    if (!is_array($get_route_gets) || $get_len !== sizeof($get_route_gets)) {
                        // V1.0.0
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_GET_PARAMS_FAILED');
                    }
                }
            }
            
        } else {
            // V1.0.0
            coreErrorController::throw_coreError('ERR_NEOCORTEX_ROUTE_HTTP_GET_PARAMS_FAILED');
        }
    }

    /*
        Get the route and the route_get_params
        V1.0.0
    */
    public static function get_request_route_params()
    {
        $ncortex_GET_splitted = explode('/', $_GET["ncortex"]);
        $point = strtolower(trim($ncortex_GET_splitted[0]));
        $function = null;
        $GET_params = null;

        $GET_params_splitted = $ncortex_GET_splitted;

        switch (sizeof($ncortex_GET_splitted)) {
            case 2:
                $function = strtolower(trim($GET_params_splitted[1]));
                break;

            case 3:
                $function = $GET_params_splitted[1];
                $GET_params = $GET_params_splitted[2];
        }

        return [$point, $function, $GET_params];
    }

    /*
        Get the public flag from the route
        V1.0.0
    */
    public static function is_Public()
    {
        $ncortex_GET_splitted = explode('/', $_GET["ncortex"]);
        $point = $ncortex_GET_splitted[0];

        $json_route_file_path = CORE_ROOT_PATH . ROUTES_JSON_FILE;
        $routes_content = file_get_contents($json_route_file_path);
        $routes = json_decode($routes_content);

        $isPublic = $routes->{$point}->public;

        return $isPublic;
    }

   /*
        Gets the login flag from the route
        V1.0.0
    */
    public static function is_Login()
    {
        $route_params = self::get_request_route_params();

        if (
            $route_params[0] === 'login' ||
            ($route_params[0] === 'signup' &&
                $route_params[1] === 'finish')
        ) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Gets the permission level from the route
        V1.0.0
    */
    public static function get_route_permission()
    {
        $route_params = self::get_request_route_params();
        if ($route_params[1] === null) {
            $route_params[1] = 'index';
        }

        $json_route_file_path = CORE_ROOT_PATH . ROUTES_JSON_FILE;
        $routes_content = file_get_contents($json_route_file_path);
        $routes = json_decode($routes_content);

        $permission = $routes->{$route_params[0]}->get_functions->{$route_params[1]}->permission;
        return $permission;
    }
}

// V1.0.0