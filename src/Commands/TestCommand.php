<?php

namespace Lucius\ShineMonitorApi\Commands;

use Exception;
use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use Spatie\FlareClient\Http\Exceptions\BadResponseCode;

class TestCommand extends Command
{
    protected $signature = 'shinemonitor:test';

    protected $description = 'Send authentication request to ShineMonitor';

    protected Repository $config;

    public function handle(Repository $config): void
    {
        $this->config = $config;

        $this->sendTestException();
    }

    protected function sendTestException(): void
    {
        $testException = new Exception('This is an exception to test if the integration with ShineMonitor works.');

        try {
        } catch (Exception $exception) {
        }
    }
}
