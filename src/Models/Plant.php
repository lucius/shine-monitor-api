<?php

namespace Lucius\ShineMonitorApi\Models;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Lucius\ShineMonitorApi\Requests\ShineMonitorAuthenticatedRequest;

class Plant extends ShineMonitorModel
{
    public $pid;

    public $uid;

    public $name;

    public $status;

    public $energyOffset;

    public $address;

    public $profit;

    public $nominalPower;

    public $energyYearEstimate;

    public $picBig;

    public $picSmall;

    public $install;

    public $gts;

    public $flag;

    public static function find(int $plantPid)
    {
        $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantInfo', [
            'plantid' => $plantPid,
        ]);
        $response = $request->send();

        if ($response->successful()) {
            return Plant::makeFromResponse($response);
        } else {
            throw new \Exception($response->error()->description());
        }
    }

    public static function getActiveOutputPower(int $plantPid): float
    {
        $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantActiveOuputPowerCurrent', [
            'plantid' => $plantPid,
        ]);
        $response = $request->send();
        if ($response->successful()) {
            return floatval($response->json()['outputPower']);
        } else {
            throw new \Exception($response->error()->description());
        }
    }

    public static function getActiveOutputPowerOneDay(int $plantPid): Collection
    {
        $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantActiveOuputPowerOneDay', [
            'plantid' => $plantPid,
        ]);
        $response = $request->send();

        return TimeSeriesValue::makeFromResponse($response, 'outputPower');
    }

    public static function getPlantEnergyMonthPerDay(int $plantId): Collection
    {
        $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantEnergyMonthPerDay', [
            'plantid' => $plantId,
            'date' => Carbon::now()->format('Y-m'),
        ]);
        $response = $request->send();

        return TimeSeriesValue::makeFromResponse($response, 'perday');
    }

    public static function getPlantEnergyYearPerMonth(int $plantId): Collection
    {
        $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantEnergyYearPerMonth', [
            'plantid' => $plantId,
            'date' => \Illuminate\Support\Carbon::now()->format('Y'),
        ]);
        $response = $request->send();

        return TimeSeriesValue::makeFromResponse($response, 'permonth');
    }
}
