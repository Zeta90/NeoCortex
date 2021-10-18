<?php

/**
 * ResponseController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class ResponseController
{
    /*
        Release the error to the client
        V1.0.0
    */
    public static function release_coreError(string $http_coreError_code, string $coreError_message)
    {
        $res = array(
            "http_code" =>$http_coreError_code,
            "result" => array("message" =>$coreError_message)
        );

        $res = json_encode($res);

        die($res);
    }

    /*
        Release the response to the client
        V1.0.0
    */
    public static function release()
    {
        $result = ResultModel::$result;
        $http_response_code = $result['_code'];

        unset($result['_code']);

        $res = array(
            "http_code" => $http_response_code,
            "result" => $result
        );

        $res = json_encode($res);

        FeedController::feed_general();

        die($res);
    }
}

// V1.0.0