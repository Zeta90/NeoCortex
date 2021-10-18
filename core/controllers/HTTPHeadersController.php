<?php

/**
 * HTTPHeadersController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class HTTPHeadersController
{
    /*
        Check the disponibility out of the required initial API headers
        V1.0.0
    */
    public static function validate_headers()
    {
        if (!isset($_SERVER['HTTP_AUTHTOKEN'])) {
            // V1.0.0
            coreErrorController::throw_coreError('ERR_NEOCORTEX_REQUIRED_HTTP_HEADER_AUTHTOKEN_NOT_FOUND');
        }

        if (!isset($_SERVER["HTTP_USER_AGENT"])) {
            if (!isset($_SERVER["HTTP_TOKENAGENT"])) {
                // V1.0.0
                coreErrorController::throw_coreError('ERR_NEOCORTEX_REQUIRED_HTTP_HEADER_AGENT_NOT_FOUND');
            }
        }
    }

    /*
        Return the requested HTTP header value
        V1.0.0
    */
    public static function getHeader($header, $is_http = false)
    {
        $header_name = '';

        if ($is_http === true) {
            $header_name .= 'HTTP_';
        }

        $header_name .= $header;

        if (
            isset($_SERVER[$header_name])
            && $_SERVER[$header_name] != null
            && strlen(trim($_SERVER[$header_name] > 0))
        ) {
            return $_SERVER[$header_name];
        } else {
            return false;
        }
    }

    /*
        Return the request HTTP host
        V1.0.0
    */
    public static function get_http_host()
    {
        $host = self::getHeader('TOKENHOST', true);

        if ($host === false) {
            $host = $_SERVER["REMOTE_ADDR"];
        }

        return $host;
    }

    /*
        Return the request HTTP Agent
        V1.0.0
    */
    public static function get_http_agent()
    {
        $agent = self::getHeader('TOKENAGENT', true);

        if ($agent === false) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
        }

        return $agent;
    }

    /*
        Resolve the HTTP request for NeoCortexcoreError statements
        V1.0.0
    */
    public static function summarize_request()
    {
        $coreError_headers = $_SERVER['SERVER_PROTOCOL'] . ' ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . PHP_EOL;

        foreach (getallheaders() as $key => $value) {
            $coreError_headers .= trim($key) . ': ' . trim($value) . PHP_EOL;
        }

        return $coreError_headers;
    }
}

/**
 * HTTPHeadersResponseController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class HTTPHeadersResponseController
{
    /*
        Set new HTTP header within the response
        V1.0.0
    */
    public static function set_global_response_header(string $key, string $value)
    {
        header($key . ": " . $value);
    }

    // /*
    //     Sets the code HTTP header response
    // */
    // public static function set_response_code(int $response_code)
    // {
    //     http_response_code($response_code);
    // }
}

// V1.0.0