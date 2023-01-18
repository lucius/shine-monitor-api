<?php

namespace Lucius\ShineMonitorApi\Models;


use Lucius\ShineMonitorApi\Contracts\ShineMonitorModelContract;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

abstract class ShineMonitorModel implements ShineMonitorModelContract
{
    public function __construct(array $responseData)
    {
        foreach($responseData as $prop => $value) {
            if(property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }

    public static function makeFromResponse(ShineMonitorResponse $response): self
    {
        return new static($response->json());
    }
}
