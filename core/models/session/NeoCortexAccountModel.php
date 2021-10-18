<?php

/**
 * NeoCortexAccountModel
 *
 * @category   API
 * @package    NeoCortex
 * @author     David Iglesias <davidoff.igle@gmail.com>
 * @version    1.0.0
 * @link       http://pear.php.net/package/PackageName
 * @since      File available since Release 1.0.0
 */

class NeoCortexAccountModel
{
    private string $accountNo;
    public string $public_accountNo;
    private string $email;
    private string $status;
    private int $permission;
    private bool $active;
    private string $type;
    private string $public_username;
    private bool $keep_session;
    private bool $streaming;

    public function __construct(
        string $accountNo,
        string $public_accountNo,
        string $email,
        string $status,
        int $permission,
        bool $active,
        string $type,
        string $public_username,
        bool $keep_session,
        bool $streaming
    ) {
        $this->accountNo = $accountNo;
        $this->public_accountNo = $public_accountNo;
        $this->email = $email;
        $this->status = $status;
        $this->permission = $permission;
        $this->active = $active;
        $this->type = $type;
        $this->public_username = $public_username;
        $this->keep_session = $keep_session;
        $this->streaming = $streaming;
    }

    public function get_account_data()
    {
        return array(
            'accountNo' => $this->accountNo,
            'public_accountNo' => $this->public_accountNo,
            'email' => $this->email,
            'status' => $this->status,
            'permission' => $this->permission,
            'active' => $this->active,
            'type' => $this->type,
            'public_username' => $this->public_username,
            'keep_session' => $this->keep_session,
            'streaming' => $this->streaming,
        );
    }
}
