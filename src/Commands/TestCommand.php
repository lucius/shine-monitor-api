<?php

namespace Lucius\ShineMonitorApi\Commands;

use Exception;
use Illuminate\Console\Command;
use Lucius\ShineMonitorApi\Enums\PlantStatus;
use Lucius\ShineMonitorApi\Facades\ShineMonitor;
use Lucius\ShineMonitorApi\Requests\ShineMonitorAuthenticatedRequest;
use Lucius\ShineMonitorApi\Requests\ShineMonitorSignedRequest;

class TestCommand extends Command
{
    protected $signature = 'shinemonitor:test';

    protected $description = 'Send authentication request to ShineMonitor';

    public function handle(): void
    {
        try {
            $request = new ShineMonitorSignedRequest('get', 'auth', [
                'usr' => '',
                'password' => '',
                'company-key' => config('shine-monitor.company_key'),
            ]);
            $authResponse = ShineMonitor::send($request);

            $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlants', [
                'status' => PlantStatus::PLANT_STATUS_ONLINE,
                'orderBy' => 'ascPlantName',
                'page' => 0,
                'pageSize' => 10,
                'source' => 0,
            ]);
            $request->setToken($authResponse->json()['dat']['token']);
            $request->setSecret($authResponse->json()['dat']['secret']);
            $response = ShineMonitor::send($request);
//            dd($response->json());

            $request = new ShineMonitorAuthenticatedRequest('get', 'queryPlantActiveOuputPowerOneDay', [
                'plantid' => $response->json()['dat']['plant']['0']['pid'],
                'date' => date('Y-m-d'),
            ]);
            $request->setToken($authResponse->json()['dat']['token']);
            $request->setSecret($authResponse->json()['dat']['secret']);
            $response = ShineMonitor::send($request);
            dd($response->json());

            //queryPlantActiveOuputPowerCurrent
            //queryPlantDeviceStatus: plantid
            //queryPlantActiveOuputPowerOneDay: plantid, date=Y-m-d
            //queryPlantEnergyDay
            //queryPlantEnergyMonth
            //queryPlantEnergyYear
            //queryPlantEnergyTotal
            //queryPlantEnergyMonthPerDay
            //queryPlantEnergyYearPerMonth
            //queryPlantEnergyTotalPerYear
        } catch (Exception $exception) {
            dd($exception);
        }
    }
}
