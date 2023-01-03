<?php

namespace Lucius\ShineMonitorApi\Facades;

use Illuminate\Support\Facades\Facade;
use Lucius\ShineMonitorApi\ShineMonitorClient;

/**
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
