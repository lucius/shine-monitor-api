<?php

namespace Lucius\ShineMonitorApi;

use Illuminate\Support\Facades\Http;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorRequestContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

class ShineMonitorClient
{
    public function send(ShineMonitorRequestContract $request): ShineMonitorResponseContract
    {
        $method = mb_convert_case($request->getMethod(), MB_CASE_LOWER);
        $response = Http::ShineMonitor()->{$method}('/', $request->getData());

        return new ShineMonitorResponse($response);
    }
}
