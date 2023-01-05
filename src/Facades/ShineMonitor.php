<?php

namespace Lucius\ShineMonitorApi\Facades;

use Illuminate\Support\Facades\Facade;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorRequestContract;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorResponseContract;
use Lucius\ShineMonitorApi\ShineMonitorClient;

/**
 * @method static ShineMonitorResponseContract send(ShineMonitorRequestContract $request)
 *
 * @see ShineMonitorClient
 */
class ShineMonitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ShineMonitorClient::class;
    }
}
