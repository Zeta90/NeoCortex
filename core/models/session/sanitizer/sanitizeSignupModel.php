<?php

/**
 * sanitizeSignupModel
 *
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class sanitizeSignupModel
{
    public static function sanitize_signup_application()
    {
        $signup_data = [];
        $_userMail = strlen(trim($_POST["email"])) > 0 ? trim($_POST["email"]) : false;
        $_userPassword = strlen(trim($_POST["password"])) > 0 ? trim($_POST["password"]) : false;
        $_userPublicName = strlen(trim($_POST["publicName"])) > 0 ? trim($_POST["publicName"]) : false;

        if ($_userMail !== false) {
            if (strlen($_userMail) < 8 || strlen($_userMail) > 320) {
                // ERROR: email lenght should be in range[8,100]
                // ERR_SIGNUP_PUBLIC_NAME_LEN
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_LEN_FAILED');
            }

            $valid_email = SessionController::check_valid_email($_userMail);

            if ($valid_email === false) {
                // ERROR: invalid email
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_EMAIL_NOT_VALID');
            }

            array_push($signup_data, $_userMail);
        } else {
            // MISSING email
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_EMAIL_NOT_FOUND');
        }

        if ($_userPassword !== false) {
            if (strlen($_userPassword) < 8 || strlen($_userPassword) > 100) {
                // ERROR: userFirstName lenght should be in range[3,50]
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PASSWORD_LEN_FAILED');
            }

            array_push($signup_data, $_userPassword);
        } else {
            // MISSING password
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PASSWORD_NOT_FOUND');
        }

        if ($_userPublicName !== false) {
            if (strlen($_userPublicName) < 3 || strlen($_userPublicName) > 100 || strlen($_userPublicName) > 100) {
                // ERROR: publicName lenght should be in range[3,100]
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PUBLIC_NAME_LEN_FAILED');
            }

            array_push($signup_data, $_userPublicName);
        } else {
            // MISSING publicName
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_APPLICATION_PUBLIC_NAME_NOT_FOUND');
        }

        return $signup_data;
    }

    public static function sanitize_signup_account()
    {
        $signup_data = [];
        $_userMail = strlen(trim($_POST["email"])) > 0 ? trim($_POST["email"]) : false;
        $_userFirstName = strlen(trim($_POST["userFirstName"])) > 0 ? trim($_POST["userFirstName"]) : false;
        $_userLastName = strlen(trim($_POST["userLastName"])) > 0 ? trim($_POST["userLastName"]) : false;
        $_userDOB = strlen(trim($_POST["userDOB"])) > 0 ? trim($_POST["userDOB"]) : false;

        if ($_userMail !== false) {
            $email = trim($_userMail);

            if (strlen($_userMail) < 8 || strlen($_userMail) > 320) {
                // ERROR: email lenght should be in range[8,100]
                // ERR_SIGNUP_PUBLIC_NAME_LEN
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_LEN_FAILED');
            }

            $valid_email = SessionController::check_valid_email($_userMail);

            if ($valid_email === false) {
                // ERROR: invalid email
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_NOT_VALID');
            }

            array_push($signup_data, $_userMail);
        } else {
            // MISSING email
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_EMAIL_NOT_FOUND');
        }

        if ($_userFirstName !== false) {
            $userFirstName = trim($_userFirstName);

            if (strlen($userFirstName) < 3 || strlen($userFirstName) > 100) {
                // ERROR: userFirstName lenght should be in range[3,50]
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_FNAME_LEN_FAILED');
            }

            array_push($signup_data, $userFirstName);
        } else {
            // MISSING publicName
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_FNAME_NOT_FOUND');
        }

            if ($_userLastName !== false) {
                $userLastName = trim($_userLastName);

                if (strlen($userLastName) < 3 || strlen($userLastName) > 100) {
                    // ERROR: userLastName lenght should be in range[3,100]
                    coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_LNAME_LEN_FAILED');
                }

                array_push($signup_data, $userLastName);
            } else {
                // MISSING email
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_LNAME_NOT_FOUND');
            }

            if ($_userDOB !== false) {
                $userDOB = trim($_userDOB);

                if (strlen($userDOB) !== 10) {
                    // ERROR: userDOB lenght should be in range[3,50]
                    coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_DOB_LEN_FAILED');
                }

                array_push($signup_data, $userDOB);
            } else {
                // MISSING password
                coreErrorController::throw_coreError('ERR_NEOCORTEX_SANITIZE_SIGNUP_ACCOUNT_DOB_LEN_FAILED');
            }

            return $signup_data;
    }
}