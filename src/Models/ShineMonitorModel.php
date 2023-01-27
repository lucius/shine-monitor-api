<?php

namespace Lucius\ShineMonitorApi\Models;

use ArrayAccess;
use GuzzleHttp\Utils;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;
use Livewire\Wireable;
use Lucius\ShineMonitorApi\Contracts\ShineMonitorModelContract;
use Lucius\ShineMonitorApi\Responses\ShineMonitorResponse;

abstract class ShineMonitorModel implements ShineMonitorModelContract, Arrayable, ArrayAccess, Jsonable, JsonSerializable, Wireable
{
    public function __construct(ArrayAccess|array $responseData)
    {
        foreach ($responseData as $prop => $value) {
            if (property_exists($this, $prop)) {
                $this->{$prop} = $value;
            }
        }
    }

    public static function makeFromResponse(ShineMonitorResponse $response, string|null $root = null): mixed
    {
        $jsonResponse = $response->json();
        if (! empty($root)) {
            $jsonResponse = $jsonResponse[$root];
        }
        if (! empty($jsonResponse[0])) {
            return (new Collection($jsonResponse))->map(function ($item) {
                return static::makeFromArray($item);
            });
        }

        return static::makeFromArray($jsonResponse);
    }

    public static function makeFromArray(array $data): mixed
    {
        return new static($data);
    }

    public function toArray()
    {
        return (array) $this;
    }

    public function offsetExists(mixed $offset): bool
    {
        $reflection = new \ReflectionObject($this);
        if (! empty($property = $reflection->getProperty($offset)) && $property->isPublic()) {
            return true;
        }

        return false;
    }

    public function offsetGet(mixed $offset): mixed
    {
        if ($this->offsetExists($offset)) {
            return $this->{$offset};
        }

        throw new \OutOfRangeException($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($this->offsetExists($offset)) {
            $this->{$offset} = $value;
        }

        throw new \OutOfRangeException($offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        if ($this->offsetExists($offset)) {
            unset($this->{$offset});
        }
    }

    public function toJson($options = 0)
    {
        return Utils::jsonEncode($this->toArray());
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function toLivewire()
    {
        return $this->jsonSerialize();
    }

    public static function fromLivewire($value)
    {
        return self::makeFromArray($value);
    }
}
