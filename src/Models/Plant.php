<?php

namespace Lucius\ShineMonitorApi\Models;


use Carbon\Carbon;
use Lucius\ShineMonitorApi\Enums\PlantStatus;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

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

    public static function getSamplePlant()
    {
        return new static([
            "pid" => 1077810,
            "uid" => 4140089,
            "name" => "Casa",
            "status" => 7,
            "energyOffset" => 0.0,
            "address" => [
                "country" => "Brasil",
                "province" => "Paraná",
                "city" => "Londrina",
                "county" => "Parque Residencial Alcântara",
                "address" => "Rua Ivete Abibe, 65",
                "lon" => "-51.167444",
                "lat" => "-23.347884",
                "timezone" => -10800,
            ],
            "profit" => [
                "unitProfit" => "0.6636",
                "currency" => "R$",
                "coal" => "0.400",
                "co2" => "0.990",
                "so2" => "0.030",
                "soldProfit" => 0.0,
                "selfProfit" => 0.0,
                "purchProfit" => 0.0,
                "consProfit" => 0.0,
                "feedProfit" => 0.0,
            ],
            "nominalPower" => "4.4000",
            "energyYearEstimate" => "0.0000",
            "picBig" => "https://img.shinemonitor.com/img/2022/11/25/202211250154308924FF2430A.jpg",
            "picSmall" => "https://img.shinemonitor.com/img/2022/11/25/202211250154308924FF2430B.jpg",
            "install" => "2022-11-24 14:54:32",
            "gts" => "2022-11-24 14:54:32",
            "flag" => true,
        ]);
    }
}
