<?php

namespace Lucius\ShineMonitorApi\Responses;

use Illuminate\Http\Client\Response;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\Enums\ShineMonitorErrorCode;

class ShineMonitorResponse implements ShineMonitorResponseContract
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function successful(): bool
    {
        return $this->response->successful() && empty($this->response->json('err', 0));
    }

    public function json(): array
    {
        return $this->response->json();
    }

    public function headers()
    {
        return $this->response->headers();
    }

    public function error(): ShineMonitorErrorCode
    {
        return ShineMonitorErrorCode::from($this->response->json('err'));
    }
}
