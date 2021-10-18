<?php

/**
 * coreErrorController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class coreErrorController
{
    /*
        Manage the exception creation and define a new coreError
        V1.0.0
    */
    public static function throw_coreError(string $coreError_code, $except = null)
    {
        TimerController::set_error_time();

        require_once 'core/cfg/constants/error.php';

        if ($except === null) {
            $ex = new Exception($coreError_code);
        } else {
            $ex = $except;
        }

        $coreError_info = get_defined_constants(true)['user'][$coreError_code];
        $coreError_isCrash = $coreError_info['crash'];
        $http_coreError_code = $coreError_info['http'];
        $coreError_message = $coreError_info['message'];

        // Feed
        FeedController::feed_coreError($coreError_isCrash, $coreError_info, $ex);

        // Release error to user
        ResponseController::release_coreError($http_coreError_code, $coreError_message);
    }
}

// V1.0.0