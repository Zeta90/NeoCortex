<?php

/**
 * FeedController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class FeedController
{
    /*
        Feed the crash request
        V1.0.0
    */
    public static function feed_coreError(bool $coreError_isCrash, array $crash_data, Exception $ex)
    {
        $static_trace = $crash_data['static_trace'];
        $type_error = $crash_data['type'];

        $feed_statement = self::summarize_request_data();

        TimerController::set_request_end_time();
        $feed_times = TimerController::get_times();
        // $feed_times = json_encode($feed_times);

        $feed_data = array(
            'statement' => $feed_statement,
            'time' => $feed_times,
            'err_code' => $ex->getMessage(),
            "err_type" => $type_error,
            "exception"=> $ex->getTrace()
        );

        $dbName = ($coreError_isCrash) ? FEED_MONGO_CORE_CRASH : FEED_MONGO_CORE_REQUEST;

        $mongoDB = databasesController::mongoDB();
        $mongoDB->single_insert($dbName, $static_trace, $feed_data);
    }

    /*
        Get the session data from the feed
        V1.0.0
    */
    public static function feed_general()
    {
        $session = isset(SessionController::$account) ? SessionController::$account : null;
        
        if ($session === null) {
            $public_accountNo = 'PUBLIC';
        } else {
            $public_accountNo = $session->public_accountNo;
        }

        TimerController::set_request_end_time();
        $feed_times = TimerController::get_times();
        // $feed_times = json_encode($feed_times);

        $feed_statement = self::summarize_request_data();

        $feed_data = array(
            'statement' => $feed_statement,
            'time' => $feed_times,
        );

        $mongoDB = databasesController::mongoDB();
        $mongoDB->single_insert(FEED_MONGO_CORE_REQUEST, $public_accountNo, $feed_data);
    }

    /*
        Feed the session data
        V1.0.0
    */
    public static function feed_session(string $public_accountNo, string $new_sessionToken_server)
    {
        $redis = databasesController::RedisDB();
        $redis->_set($public_accountNo, $new_sessionToken_server, 'feed_session');
    }

    /*
        Get the session data from the feed
        V1.0.0
    */
    public static function get_session_data(string $public_accNo)
    {
        $redis = databasesController::RedisDB();
        $feed_account = $redis->_get($public_accNo, 'feed_session');
        $feed_account = json_decode($feed_account, true);

        return $feed_account;
    }

    /*
        Summarize the error info including HTTP Headers
        V1.0.0
    */
    private static function summarize_request_data()
    {
        $raw_request = '';
        $raw_request = HTTPHeadersController::summarize_request();
        $raw_request .= PHP_EOL;
        $raw_request .= 'HTTP_HOST: ' . $_SERVER["HTTP_HOST"] . PHP_EOL;
        $raw_request .= 'REMOTE_ADDR: ' . $_SERVER["REMOTE_ADDR"] . PHP_EOL;
       
        if(isset($_SERVER["HTTP_TOKENAGENT"])){
            $raw_request .= 'HTTP_TOKENAGENT: ' . $_SERVER["HTTP_TOKENAGENT"] . PHP_EOL;
        }

        if(isset($_SERVER["HTTP_USER_AGENT"])){
            $raw_request .= 'HTTP_USER_AGENT: ' . $_SERVER["HTTP_USER_AGENT"];
        }

        $_req = $_REQUEST;
        unset($_req['password']);

        $raw_request .= json_encode($_req);

        return $raw_request;
    }
}

// V1.0.0