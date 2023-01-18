<?php

namespace Lucius\ShineMonitorApi\Models;


use Carbon\Carbon;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

class AuthenticationData extends ShineMonitorModel
{
    public $secret;
    public $expire;
    public $expires_at;
    public $token;
    public $role;
    public $usr;
    public $uid;

    public function __construct(array $responseData)
    {
        parent::__construct($responseData);

        $this->expires_at = Carbon::now()->addSeconds($this->expire);
    }

    public function isExpired()
    {
        return Carbon::now()->isBefore($this->expires_at);
    }
}
