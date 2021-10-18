<?php

/**
 * NeoCortexAppController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class NeoCortexAppController
{
    /*
        Resolves the app from the HTTP headers
        V1.0.0
    */
    public static function validate_app()
    {
        $selected_app = self::get_app_static_data();

        if ($selected_app === null) {
            // V1.0.0
            coreErrorController::throw_coreError('ERR_NEOCORTEX_APP_NOT_FOUND');
        }

        $app_port = (int) HTTPHeadersController::getHeader('SERVER_PORT', false);

        if (!in_array($app_port, $selected_app['allowed_ports'])) {
            // V1.0.0
            coreErrorController::throw_coreError('ERR_NEOCORTEX_APP_PORT_FORBIDDEN');
        }

        $authToken =  HTTPHeadersController::getHeader('AUTHTOKEN', true);
        $auth_controller = $selected_app['auth_controller'];

        $controller_path = CORE_ROOT_PATH . 'models/auth/' . $auth_controller . '.php';
        require_once $controller_path;

        $auth_result = $auth_controller::exAuth($selected_app, $authToken);

        if ($auth_result !== true) {
            // V1.0.0
            coreErrorController::throw_coreError($auth_result);
        }
    }

    /*
        Get the app data from the JSON file
        V1.0.0
    */
    private static function get_app_static_data()
    {
        $app_host = HTTPHeadersController::get_http_host();

        $json_apps_file_path = CORE_ROOT_PATH . APPS_JSON_FILE;
        $apps_content = file_get_contents($json_apps_file_path);
        $apps = json_decode($apps_content, true);

        $selected_app = null;

        foreach ($apps as $app) {
            if (in_array($app_host, $app['allowed_hosts'])) {
                $selected_app = $app;
            }
        }

        return $selected_app;
    }

    /*
        Gets the appID from the HTTP Headers
        V1.0.0
    */
    public static function _get(string $param)
    {
        $selected_app = self::get_app_static_data();
        $param_selected = $selected_app[$param];

        return $param_selected;
    }
}
// V1.0.0