<?php

namespace Lucius\ShineMonitorApi\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorModelContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\Facades\ShineMonitor;

class ShineMonitorAuthenticatedRequest extends ShineMonitorSignedRequest
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
//        $queryData = $this->data;
//        if (array_key_exists('password', $queryData)) {
//            $finalData = Arr::except($queryData, ['password']);
//        } else {
//            $finalData = $queryData;
//        }
        $finalData = $this->data;
        $queryString = \http_build_query($finalData, '', '&');
        $sign = sha1($salt
            .$this->secret
            .$token
            .'&'.$queryString
        );

        $finalData = compact('sign', 'salt', 'token') + $finalData;

        return $finalData;
    }

    public function send(): ShineMonitorResponseContract|ShineMonitorModelContract
    {
        $response = ShineMonitor::send($this);

        if ($response->successful()) {
            return $response;
        } else {
            throw new \Exception($response->error()->description());
        }
    }
}
