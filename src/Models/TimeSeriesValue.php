<?php

namespace Lucius\ShineMonitorApi\Models;

use Carbon\Carbon;

class TimeSeriesValue extends ShineMonitorModel
{
    public $ts;

    public $val;

    public function __construct(\ArrayAccess|array $responseData)
    {
        $this->ts = Carbon::createFromFormat('Y-m-d H:i:s', $responseData['ts']);
        $this->val = floatval($responseData['val']);
    }
}
