<?php

namespace Ve;

/**
 * same as array_merge (or operator +) but preserves keys even if they are numeric
 * like array_merge, the second array overrides the first
 *
 * @param array $arr1
 * @param array $arr2
 */
function mergePreserveKeys(array $arr1, array $arr2): array
{
    $allKeys = array_unique(array_keys($arr1) + array_keys($arr2));

    $result = [];

    foreach ($allKeys as $key)
    {
        if (array_key_exists($key, $arr2))
        {
            $result[$key] = $arr2[$key];
        }
        else
        {
            $result[$key] = $arr1[$key];
        }
    }

    return $result;
}

/**
 * removes arbitrarily deep nesting from iterables
 * order is preserverd, but array keys are lost
 *
 * @param array|Traversable $input
 * @return array
 */
function flatten($input): array
{
    $result = [];

    foreach ($input as $value)
    {
        if (is_array($value) || $value instanceof \Traversable)
        {
            $result = array_merge($result, flatten($value));
        }
        else
        {
            $result[] = $value;
        }
    }
    return $result;
}

function numberOfColumns(array $table): int
{
    return array_reduce($table, function($carry, $row) { return max($carry, count($row)); });
}
