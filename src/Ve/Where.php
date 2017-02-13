<?php

namespace Ve\Where;

function where($objects, $propertyMap)
{
    $result = [];

    foreach ($objects as $obj)
    {
        if (matches($obj, $propertyMap)) {
            $result[] = $obj;
        }
    }

    return $result;
}

function matches($object, $propertyMap)
{
    foreach ($propertyMap as $property => $value) {
        if (is_array($value)) {
            if (!matches(readProperty($object, $property), $value)) {
                return false;
            } else {
                continue;
            }
        }
        if (readProperty($object, $property) != $value) {
            return false;
        }
    }

    return true;
}

function readProperty($object, $property)
{
    if (is_object($object)) {
        if (property_exists($object, $property)) {
            return $object->$property;
        } elseif (method_exists($object, $property)) {
            return call_user_func([$object, $property]);
        } else {
            throw new \InvalidArgumentException(sprintf('Expected property or method %s in %s', $property, get_class($object)));
        }
    } elseif (is_array($object)) {
        return $object[$property];
    } else {
        throw new \InvalidArgumentException('Expected object or array');
    }
}
