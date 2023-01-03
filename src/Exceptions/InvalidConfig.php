<?php

namespace Lucius\ShineMonitorApi\Exceptions;

use Exception;
use Monolog\Logger;

class InvalidConfig extends Exception
{
    public static function invalidLogLevel(string $logLevel): self
    {
        return new self("Invalid log level `{$logLevel}` specified.");
    }
}
