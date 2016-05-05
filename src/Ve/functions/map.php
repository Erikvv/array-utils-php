<?php

namespace Ve;

/**
 * calls a method on all objects
 *
 * @param $objects array|Traversable
 * @param $method string
 */
function map($objects, string $method): array
{
    $result = [];

    foreach ($objects as $obj)
    {
        $result[] = $obj->$method();
    }

    return $result;
}

/**
 * gets a property from all objects
 *
 * @param $objects array|Traversable
 * @param $property string
 */
function pluck($objects, string $property): array
{
    $result = [];

    foreach ($objects as $obj)
    {
        $result[] = $obj->property;
    }

    return $result;
}

/**
 * array_map does not allow us to
 *         (1) access keys of the input or
 *        (2) determine the keys of the output
 * without getting rather creative with array_keys, array_flip
 * or using array_walk, which is impure and does not allow to create new keys
 *
 * this function can do both
 *
 * the callback MUST return an array (because of the output key)
 * the resulting arrays will be merged
 */
function mapWithKey(array $array, callable $fn)
{
    $result = [];

    foreach ($array as $key => $value)
    {
        $result += $fn($value, $key);
    }

    return $result;
}

/**
 * Helper to build and associative array of properties from a collection of objects,
 * e.g. from object ID's to object properties
 */
function buildAssoc(array $objects, string $keyProperty, string $valueProperty): array
{
    $keys   = pluck($objects, $keyProperty);
    $values = pluck($objects, $valueProperty);

    return array_combine($keys, $values);
}
