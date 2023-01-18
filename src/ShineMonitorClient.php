<?php

namespace Lucius\ShineMonitorApi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorRequestContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\Facades\ShineMonitor;
use Lucius\ShineMonitorApi\Models\AuthenticationData;
use Lucius\ShineMonitorApi\Requests\ShineMonitorAuthenticatedRequest;
use Lucius\ShineMonitorApi\Requests\ShineMonitorSignedRequest;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

class ShineMonitorClient
{
    protected ?AuthenticationData $authData;

    public function __construct()
    {
        $this->authData = Cache::get(static::class . '-authData', null);
    }

    public function send(ShineMonitorRequestContract $request): ShineMonitorResponseContract
    {
        if(is_a($request, ShineMonitorAuthenticatedRequest::class)) {
            $this->authenticateRequest($request);
        }
        $method = mb_convert_case($request->getMethod(), MB_CASE_LOWER);
        $response = Http::ShineMonitor()->{$method}('/', $request->getData());

        return new ShineMonitorResponse($response);
    }

    protected function authenticateRequest(ShineMonitorRequestContract &$request)
    {
        $this->authenticate();

        $request->setSecret($this->authData->secret);
        $request->setToken($this->authData->token);
    }

    public function authenticate()
    {
        if(empty($this->authData)) {
            $request = new ShineMonitorSignedRequest('get', 'auth', [
                'usr' => env('SHINEMONITOR_USERNAME'),
                'password' => env('SHINEMONITOR_PASSWORD'),
                'company-key' => config('shine-monitor.company_key'),
            ]);
            $this->authData = $request->send();

            Cache::forever(static::class . '-authData', $this->authData);
        } elseif($this->authData->isExpired()) {
            // Refresh
        } else {
            return $this->authData;
        }

    }
}
