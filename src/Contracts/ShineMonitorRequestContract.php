<?php

namespace Lucius\ShineMonitorApi\Contracts;

interface ShineMonitorRequestContract
{
    public function getMethod(): string;

    public function getData(): array;

    public function send(): ShineMonitorResponseContract;
}
