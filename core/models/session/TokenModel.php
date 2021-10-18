<?php

/**
 * TokenModel
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class TokenModel
{
    /**
     * Process the client SESSIONTOKEN
     */
    public static function decryp_session_token()
    {
        $sessionToken = HTTPHeadersController::getHeader('SESSIONTOKEN', true);
        $raw_token = base64_decode($sessionToken);
        $token_split_1 = explode('-', $raw_token);

        if (sizeof($token_split_1) != 2) {
            // Request Token unknown format
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_1');
        }

        $rnd1 = (substr($token_split_1[0], 0, 3));
        $rnd2 = (substr($token_split_1[0], 3, 6));
        $numerized_accNo = (substr($token_split_1[0], 9));

        $accNo__ = strval(intval($numerized_accNo) / intval($rnd1));

        $token_split_2 = explode('%', $token_split_1[1]);

        if (sizeof($token_split_2) != 2) {
            // Request Token unknown format
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_2');
        }

        $numerized_time_session = $token_split_2[0];

        $time_session__ = strval(intval(intval($numerized_time_session) / intval($rnd2)));
        $crc_checker = $token_split_2[1];

        $decrypted_token = array(
            'public_accNo' => $accNo__,
            'time_session' => $time_session__,
            'crc_checker' => $crc_checker,
        );

        if (strlen($accNo__) !== 10) {
            // Request Token unknown format
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_3');
        }
        return $decrypted_token;
    }

    /**
     * Generate new SESSIONTOKEN
     * V1.0.0
     */
    public static function generate_session_token(NeoCortexAccountModel &$account, bool $is_login = false)
    {
        $account_data = $account->get_account_data();

        $token_obj = new stdClass();

        if($is_login === true){
            TimerController::set_login_times();
        }else{
            TimerController::set_checkpoint_times();
        }

        $token_times = TimerController::get_token_times();

        $token_obj->session_start = strval($token_times['session_start']);
        $token_obj->session_checkpoint = strval($token_times['session_checkpoint']);

        $token_obj->accountNo = $account_data["accountNo"];
        $token_obj->public_accountNo = $account_data["public_accountNo"];
        $token_obj->email = $account_data["email"];
        $token_obj->status = $account_data["status"];
        $token_obj->permission = $account_data["permission"];
        $token_obj->active = $account_data["active"];
        $token_obj->type = $account_data["type"];
        $token_obj->public_username = $account_data["public_username"];
        $token_obj->host = HTTPHeadersController::get_http_host();
        $token_obj->agent = HTTPHeadersController::get_http_agent();
        $token_obj->keep_session = $account_data['keep_session'];
        $token_obj->streaming = $account_data['streaming'];
        $token_obj->appID = NeoCortexAppController::_get('ID');

        // Client token
        $rnd1 = self::generate_RND(3);
        $rnd2 = self::generate_RND(6);

        $public_accNo = strval($account_data["public_accountNo"]);

        $rnd1 = intval($rnd1);
        $rnd2 = intval($rnd2);

        $crc_tokenized = crc32(intval($public_accNo) + $token_times['session_checkpoint']);
        $token_body = $rnd1  . $rnd2  . strval(intval($public_accNo) * $rnd1) . '-' . strval($token_times['session_checkpoint'] * $rnd2) . '%' . $crc_tokenized;

        $token_json_server = json_encode($token_obj);
        $token_b64_client = base64_encode($token_body);

        $crypted_token = array(
            'server_token' => $token_json_server,
            'client_token' => $token_b64_client,
        );

        return $crypted_token;
    }

    /**
     * Process the client SESSIONTOKEN
     * V1.0.0
     */
    public static function checkout_session_time(int $token_checkpoint, int $account_checkpoint)
    {
        if ($token_checkpoint !== $account_checkpoint) {
            coreErrorController::throw_coreError('ERR_NEOCORTEX_SESSIONTOKEN_FALSIFIED_FORMAT_LEVEL_4');
        }
    }

    /**
     * Randomizer for SESSIONTOKEN
     * V1.0.0
     */
    private static function generate_RND($total_rnds)
    {
        $rnd = '';

        for ($i = 0; $i < $total_rnds; $i++) {
            $rnd .= rand(1, 9);
        }

        return $rnd;
    }
}
