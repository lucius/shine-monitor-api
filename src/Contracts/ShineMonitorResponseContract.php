<?php

namespace Lucius\ShineMonitorApi\Contracts;

use Lucius\ShineMonitorApi\Enums\ShineMonitorErrorCode;

interface ShineMonitorResponseContract
{
    public function successful(): bool;

    public function json(): array;

    public function headers();

    public function error(): ShineMonitorErrorCode;
}
