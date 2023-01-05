<?php

namespace Lucius\ShineMonitorApi\Enums;

enum PlantStatus: int
{
    case PLANT_STATUS_ONLINE = 0x0000;
    case PLANT_STATUS_OFFLINE = 0x0001;
    case PLANT_STATUS_WARNING = 0x0004;
    case PLANT_STATUS_ATTENTION = 0x0007;

    public function description()
    {
        return match ($this) {
            self::PLANT_STATUS_ONLINE => 'OK',
            self::PLANT_STATUS_OFFLINE => 'Offline',
            self::PLANT_STATUS_WARNING => 'Alarme',
            self::PLANT_STATUS_ATTENTION => 'Atenção',
        };
    }
}
