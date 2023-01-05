<?php

namespace Lucius\ShineMonitorApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Lucius\ShineMonitorApi\Commands\TestCommand;
use Lucius\ShineMonitorApi\Facades\ShineMonitor;

class ShineMonitorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerConfig();
        $this->registerShineMonitor();
        $this->registerLogHandler();
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->publishConfigs();
        }

        $this->registerRoutes();
        $this->registerHttpMacros();
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shine-monitor.php', 'shine-monitor');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            TestCommand::class,
        ]);
    }

    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__.'/../config/shine-monitor.php' => config_path('shine-monitor.php'),
        ], 'shine-monitor-config');
    }

    protected function registerShineMonitor(): void
    {
        $this->app->singleton(ShineMonitor::class, function () {
            return new ShineMonitorClient();
        });
    }

    protected function registerRoutes(): void
    {
    }

    protected function registerLogHandler(): void
    {
    }

    protected function registerHttpMacros()
    {
        Http::macro('ShineMonitor', function () {
            return Http::baseUrl(config('shine-monitor.base_url'))->acceptJson();
        });
    }
}
