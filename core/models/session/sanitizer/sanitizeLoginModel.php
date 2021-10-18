<?php

/**
 * sanitizeLoginModel
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class sanitizeLoginModel
{
    /*
        Sanitize the POST data for Login
        V1.0.0
    */
    public static function sanitize_login_data()
    {
        $login_data = [];
        $_email = strlen(trim($_POST["email"]))>0 ? trim($_POST["email"]) : false;
        $_password = strlen(trim($_POST["password"]))>0 ? trim($_POST["password"]) : false;
        
        if ($_email !== false) {

            // Invalid email LEN
            if (strlen($_email) < 8 || strlen($_email) > 100) {
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_LEN_FAILED');
            }

            $valid_email = SessionController::check_valid_email($_email);

            // Invalid Email
            if ($valid_email === false) {
                // ERROR: invalid email
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_NOT_VALID');
            }

            array_push($login_data, $_email);
        } else {
            // Missing email
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_LOGIN_EMAIL_NOT_FOUND');
        }

        if ($_password !== false) {
            // Invalid pass len
            if (strlen($_password) < 8 || strlen($_password) > 100) {
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_LOGIN_PASSWORD_LEN_FAILED');
            }

            array_push($login_data, $_password);
        } else {
            // Missing password
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_LOGIN_PASSWORD_NOT_FOUND');
        }

        return $login_data;
    }
}