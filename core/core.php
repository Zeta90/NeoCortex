<?php

/**
 * NeoCortex
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias Alonso <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

// Dependencies
require_once '../vendor/autoload.php';

// Models
require_once 'core/models/ResultModel.php';

// Controllers
require_once 'core/controllers/TimerController.php';
require_once 'core/controllers/coreErrorController.php';
require_once 'core/controllers/HTTPHeadersController.php';
require_once 'core/controllers/FeedController.php';
require_once 'core/controllers/ResponseController.php';
require_once 'core/controllers/NeoCortexAppController.php';
require_once 'core/controllers/RouterController.php';
require_once 'core/controllers/SessionController.php';
require_once 'core/controllers/DatabasesController.php';

// Constants
require_once 'core/cfg/constants/api.php';

// Testing purposes
//  Debugging
if (IS_DEBUGGING) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

class NeoCortex
{
    public function __construct()
    {
        // V1.0.0
        TimerController::init_timer();

        // V1.0.0
        HTTPHeadersController::validate_headers();

        // V1.0.0
        NeoCortexAppController::validate_app();

        // V1.0.0
        RouterController::validate_route();
        
        // V1.0.0
        SessionController::open_session();

        // V1.0.0
        ResultModel::execute_request_controller();

        // V1.0.0
        ResponseController::release();
    }
}

// opcache