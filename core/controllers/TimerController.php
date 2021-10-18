<?php

/**
 * TimerController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

//  Timer Model
require_once 'core/models/TimerModel.php';

class TimerController
{
    private static TimerModel $timer;

    /**
     * Init the timer model
     * V1.0.0
     */
    public static function init_timer()
    {
        if (!isset(self::$timer)) {
            $time_now = self::get_miliseconds_now();
            self::$timer = new TimerModel($time_now);
        }
    }

    /**
     * Return the current miliseconds
     * V1.0.0
     */
    public static function get_miliseconds_now()
    {
        $milliseconds = round(microtime(true) * 1000);
        return $milliseconds;
    }

    /**
     * Get times for the token creation
     * V1.0.0
     */
    public static function get_token_times()
    {
        $timer = &self::$timer;
        $session_start = $timer->__get('session_start');
        $session_checkpoint = $timer->__get('session_checkpoint');

        $times = array(
            'session_start' => $session_start,
            'session_checkpoint' => $session_checkpoint,
        );
        return $times;
    }

    /**
     * Return all the Timer properties
     * V1.0.0
     */
    public static function get_times()
    {   
        $timer = &self::$timer;
        return $timer->get_times();
    }

    /**
     * Set up the request start time
     * V1.0.0
     */
    public static function get_request_start_time()
    {   
        $timer = &self::$timer;
        $request_start = $timer->__get('request_start');
        return $request_start;
    }

    /**
     * Set the request end time
     * V1.0.0
     */
    public static function set_request_end_time()
    {
        $timer = &self::$timer;
        $session_start = $timer->__set('request_end');
    }

    /**
     * Set the error time
     * V1.0.0
     */
    public static function set_error_time()
    {
        $timer = &self::$timer;
        $session_start = $timer->__set('error');
    }
    
    /**
     * Set Request process start time
     * V1.0.0
     */
    public static function set_process_start_time()
    {
        $timer = &self::$timer;
        $session_start = $timer->__set('process_start');
    }

    /**
     * Set Request process end time
     * V1.0.0
     */
    public static function set_process_end_time()
    {
        $timer = &self::$timer;
        $session_start = $timer->__set('process_end');
    }

    /**
     * Set times for the login step
     * V1.0.0
     */
    public static function set_login_times()
    {
        $sessiontime = self::get_miliseconds_now();

        $timer = &self::$timer;
        $timer->__set('session_start', $sessiontime);
        $timer->__set('session_checkpoint', $sessiontime);
    }

    /**
     * Set the checkpoint time
     * V1.0.0
     */
    public static function set_checkpoint_times()
    {
        $sessiontime = self::get_miliseconds_now();

        $timer = &self::$timer;
        $timer->__set('session_checkpoint', $sessiontime);
    }

    /**
     * Set account times
     * V1.0.0
     */
    public static function set_account_times(int $session_start, int $session_checkpoint)
    {
        $sessiontime = self::get_miliseconds_now();

        $timer = &self::$timer;
        $timer->__set('session_start', $session_start);
        $timer->__set('session_checkpoint', $session_checkpoint);
    }
}

// V1.0.0