<?php

/**
 * functions:
 * - filter
 * - reject
 * - where
 * - whereNot
 * - find
 * - findWhere
 */

namespace Ve;

/**
 * this exists because array_filter can't call methods
 */
function filter($objects, string $method): array
{
    $result = [];
    foreach ($objects as $obj)
    {
        if (call_user_func([$obj, $method]))
        {
            $result[] = $obj;
        }
    }
    return $result;
}

/**
 * opposite of filter
 */
function reject($objects, string $method): array
{
    $result = [];
    foreach ($objects as $obj)
    {
        if (! call_user_func([$obj, $method]))
        {
            $result[] = $obj;
        }
    }
    return $result;
}

function filterRecursive($array) 
{ 
    foreach ($input as &$value) 
    { 
        if (is_array($value)) 
        { 
            $value = array_filter_recursive($value); 
        } 
    } 

    return array_filter($input); 
}

function filterRecursiveWithCallback($array, callable $callback) 
{ 
    foreach ($input as &$value) 
    { 
        if (is_array($value)) 
        { 
            $value = array_filter_recursive($value, $callback); 
        } 
    } 

    return array_filter($input, $callback); 
} 

/**
 * logic like filter but is guaranteed to return a single result, else an exeption is thrown
 */
function find($objects, callable $fn)
{
    foreach ($objects as $obj)
    {
        if (call_user_func($fn, $obj))
        {
            return $obj;
        }
    }
    throw new \LengthException;
}


/**
 * Same as self::where, except guarantees to find 1 instance else an exception is thrown
 * Short-circuit optimization possible
 */
function findWhere($objects, array $keyValuePair)
{
    $resultCollection = where($objects, $keyValuePair);

    if (count($resultCollection) !== 1)
    {
        throw new \LengthException;
    }

    return $resultCollection[0];
}

/**
 * Filters the input by property
 *
 * Possible improvement: allow multiple key-value pairs
 *
 * @param array|Traversable $objects
 */
function where($objects, array $keyValuePair): array
{
    $property = array_keys($keyValuePair)[0];
    $value = array_values($keyValuePair)[0];

    $result = [];

    foreach ($objects as $obj)
    {
        if (is_object($obj))
        {
            if (property_exists($obj, $property))
            {
                if ($obj->$property === $value)
                {
                    $result[] = $obj;
                }
            }
            elseif (method_exists($obj, $property))
            {
                if (call_user_func([$obj, $method]) === $value)
                {
                    $result[] = $obj;
                }
            }
            else
            {
                throw new \InvalidArgumentException;
            }
        }
        elseif (is_array($obj))
        {
            if ($obj[$property] === $value)
            {
                $result[] = $obj;
            }
        }
        else
        {
            throw new \InvalidArgumentException;
        }
    }
    return $result;
}

/**
 * Filters the input by property
 *
 * Possible improvement: allow multiple key-value pairs
 *
 * @param array|Traversable $objects
 */
function whereNot($objects, array $keyValuePair): array
{
    $property = array_keys($keyValuePair)[0];
    $value = array_values($keyValuePair)[0];

    $result = [];

    foreach ($objects as $obj)
    {
        if (is_object($obj))
        {
            if (property_exists($obj, $property))
            {
                if ($obj->$property !== $value)
                {
                    $result[] = $obj;
                }
            }
            elseif (method_exists($obj, $property))
            {
                if (call_user_func([$obj, $method]) !== $value)
                {
                    $result[] = $obj;
                }
            }
            else
            {
                throw new \InvalidArgumentException;
            }
        }
        elseif (is_array($obj))
        {
            if ($obj[$property] !== $value)
            {
                $result[] = $obj;
            }
        }
        else
        {
            throw new \InvalidArgumentException;
        }
    }
    return $result;
}
