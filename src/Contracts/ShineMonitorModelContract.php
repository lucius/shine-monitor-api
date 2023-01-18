<?php

namespace Lucius\ShineMonitorApi\Contracts;

use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

interface ShineMonitorModelContract
{
    public static function makeFromResponse(ShineMonitorResponse $response): self;
}
