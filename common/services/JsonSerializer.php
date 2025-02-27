<?php declare(strict_types=1);

namespace common\services;

use ReflectionClass;
use ReflectionProperty;

class JsonSerializer
{
    public function serialize(object $object, bool $json = false): false|array|string
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        $data = [];
        foreach ($properties as $property) {
            $name = $property->getName();
            $data[$name] = $object->$name;
        }

        if ($json === true){
            return json_encode($data, JSON_PRETTY_PRINT);
        }

        return $data;
    }
}
