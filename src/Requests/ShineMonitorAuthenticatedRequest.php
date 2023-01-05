<?php

namespace Lucius\ShineMonitorApi\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorRequestContract;

class ShineMonitorAuthenticatedRequest extends ShineMonitorSignedRequest implements ShineMonitorRequestContract
{
    protected $token;

    protected $secret;

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getData(): array
    {
        $salt = Carbon::now()->getTimestampMS();
        $token = $this->token;
        $queryData = $this->data;

        if (array_key_exists('password', $queryData)) {
            $finalData = Arr::except($queryData, ['password']);
        } else {
            $finalData = $queryData;
        }
        $queryString = \http_build_query($finalData, '', '&');
        $sign = sha1($salt
            .$this->secret
            .$token
            .'&'.$queryString
        );

        $finalData = compact('sign', 'salt', 'token') + $finalData;

        return $finalData;
    }
}
