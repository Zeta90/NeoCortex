<?php

/**
 * TimerModel
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class TimerModel
{
    private int $request_start;
    private int $request_end;
    private int $process_start;
    private int $process_end;
    private int $session_start;
    private int $session_checkpoint;
    private int $error;

    /**
     * Constructor
     * V1.0.0
     */
    public function __construct(int $request_start)
    {
        $this->request_start = $request_start;
        $this->request_end = 0;
        $this->process_start = 0;
        $this->process_end = 0;
        $this->session_start = 0;
        $this->session_checkpoint = 0;
        $this->error = 0;
    }

    /**
     * Get a requested time property
     * V1.0.0
     */
    public function __get(string $prop)
    {
        return $this->$prop;
    }

    /**
     * Set a new time property
     * V1.0.0
     */
    public function __set(string $var, $val = null)
    {
        $var_val = null;
        if ($val === null) {
            $var_val = TimerController::get_miliseconds_now();
        } else {
            $var_val = $val;
        }

        $this->$var = $var_val;
    }

    /**
     * Return the Timer properties
     * V1.0.0
     */
    public function get_times()
    {
        $request_start = $this->request_start;
        $request_end = $this->request_end;
        $process_start = $this->process_start;
        $process_end = $this->process_end;
        $session_start = $this->session_start;
        $session_checkpoint = $this->session_checkpoint;
        $error = $this->error;

        $result_array = array(
            'request_start' => $request_start,
            'request_finish' => $request_end,
            'request_process_start' => $process_start,
            'request_process_finish' => $process_end,
            'session_start' => $session_start,
            'session_time' => $session_checkpoint,
            'error_time' => $error,
        );

        return $result_array;
    }
}

// V1.0.0