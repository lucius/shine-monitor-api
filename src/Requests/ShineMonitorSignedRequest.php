<?php

namespace Lucius\ShineMonitorApi\Requests;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorModelContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorRequestContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\Facades\ShineMonitor;
use Lucius\ShineMonitorApi\Models\AuthenticationData;

class ShineMonitorSignedRequest implements ShineMonitorRequestContract
{
    protected $method;

    protected $data;

    public function __construct($method, $action, $data)
    {
        $this->method = $method;
        $this->data = ['action' => $action] + $data;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getData(): array
    {
        $salt = Carbon::now()->getTimestampMS();
        $queryData = $this->data;

        if (array_key_exists('password', $queryData)) {
            $finalData = Arr::except($queryData, ['password']);
        } else {
            $finalData = $queryData;
        }
        $queryString = \http_build_query($finalData, '', '&');
        $sign = sha1($salt
            .sha1($queryData['password'])
            .'&'.$queryString
        );
        $finalData = compact('sign', 'salt') + $finalData;

        return $finalData;
    }

    public function send(): ShineMonitorResponseContract|ShineMonitorModelContract
    {
        $response = ShineMonitor::send($this);

        return AuthenticationData::makeFromResponse($response);
    }
}
