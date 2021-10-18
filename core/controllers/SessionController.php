<?php

/**
 * SessionController
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

require_once 'core/models/session/TokenModel.php';
require_once 'core/models/session/NeoCortexAccountModel.php';

class SessionController
{
    public static NeoCortexAccountModel $account;

    /*
        Open the account from the SESSIONTOKEN header
        V1.0.0
    */
    public static function open_session()
    {
        $app_security = NeoCortexAppController::_get('security');

        if ($app_security['session_required'] === true) {

            $is_public = RouterController::is_Public();

            if (!$is_public) {
                $dec_token = TokenModel::decryp_session_token();

                $token_account = FeedController::get_session_data($dec_token['public_accNo']);

                if ($token_account === null) {
                    coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSION_NOT_FOUND');
                }

                TimerController::set_account_times($token_account["session_start"], $dec_token['time_session']);

                // Token timeout and permission validation 
                $target_session_checkpoint = (int)$dec_token['time_session'];
                $current_session_checkpoint = (int)$token_account['session_checkpoint'];
                $session_timeout_mins = (int)$app_security['session_timeOut_mins'];
                $session_target_permission = (int)RouterController::get_route_permission();
                $session_current_permission = (int)$token_account['permission'];

                TokenModel::checkout_session_time($target_session_checkpoint, $current_session_checkpoint);

                // if ($session_current_permission < $session_current_permission) {
                if ($session_target_permission > $session_current_permission) {
                    coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSION_LOW_PERMISSION');
                }

                if ($token_account["keep_session"] === false) {
                    $time_request = TimerController::get_request_start_time();
                    if ($time_request > $target_session_checkpoint + $session_timeout_mins * 60 * 1000) {
                        coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSION_EXPIRED_SESSION');
                    }
                }

                $accountNo = $token_account['accountNo'];
                $public_accountNo = $token_account['public_accountNo'];
                $email = $token_account['email'];
                $status = $token_account['status'];
                $permission = $token_account['permission'];
                $active = $token_account['active'];
                $type = $token_account['type'];
                $public_username = $token_account['public_username'];
                $keep_session = self::get_keepsession_value();
                $streaming = $token_account['streaming'];

                self::$account = new NeoCortexAccountModel(
                    $accountNo,
                    $public_accountNo,
                    $email,
                    $status,
                    $permission,
                    $active,
                    $type,
                    $public_username,
                    $keep_session,
                    $streaming
                );

                $new_sessionToken = TokenModel::generate_session_token(self::$account);

                $new_sessionToken_server = $new_sessionToken['server_token'];
                $new_sessionToken_client = $new_sessionToken['client_token'];

                FeedController::feed_session($public_accountNo, $new_sessionToken_server);

                HTTPHeadersResponseController::set_global_response_header('SESSIONTOKEN', $new_sessionToken_client);
            }
        }
    }

    /*
        Sets the account info from the login process
        V1.0.0
    */
    public static function set_account_login_data(array $account_data)
    {
        $accountNo = $account_data['accountNo'];
        $public_accountNo = $account_data['public_accountNo'];
        $email = $account_data['email'];
        $status = $account_data['status'];
        $permission = $account_data['permission'];
        $active = $account_data['active'];
        $type = $account_data['type'];
        $public_username = $account_data['public_username'];
        $keep_session = false;
        $streaming = false;

        self::$account = new NeoCortexAccountModel(
            $accountNo,
            $public_accountNo,
            $email,
            $status,
            $permission,
            $active,
            $type,
            $public_username,
            $keep_session,
            $streaming
        );

        TimerController::set_login_times();

        // Generate Token
        $new_sessionToken = TokenModel::generate_session_token(self::$account, true);

        $new_sessionToken_server = $new_sessionToken['server_token'];
        $new_sessionToken_client = $new_sessionToken['client_token'];

        FeedController::feed_session($public_accountNo, $new_sessionToken_server);

        HTTPHeadersResponseController::set_global_response_header('SESSIONTOKEN', $new_sessionToken_client);
    }

    /*
        Check if the email is valid format
        V1.0.0
    */
    public static function check_valid_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Return the 'keepsession' value
        V1.0.0
    */
    public static function get_keepsession_value()
    {
        return (isset($_POST["keepSession"]) && is_bool($_POST["keepSession"])) ? $_POST["keepSession"] : false;
    }
}

// V1.0.0