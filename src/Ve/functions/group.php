<?php

namespace Ve;

/**
 * @var objects array|traversable of objects
 * @var $properties property to group by.
 *          If multiple are given they are treated as nested properties ($obj->prop1->prop2->prop3)
 * @return array nested in groups
 */
function groupByProperty($objects, string ...$properties): array
{
    $result = [];
    foreach ($objects as $obj)
    {
        $value = $obj;
        foreach ($properties as $prop)
        {
            $value = $value->$prop;
        }
        $result[$value][] = $obj;
    }
    return $result;
}

function groupByMethod($objects, string $method): array
{
    $result = [];
    foreach ($objects as $obj)
    {
        $result[call_user_func([$obj, $method])][] = $obj;
    }
    return $result;
}

function groupByCallable($list, callable $callable): array
{
    $result = [];
    foreach ($list as $var)
    {
        $result[call_user_func($callable, $var)][] = $var;
    }
    return $result;
}

/**
 * @param Traversable|array $list
 * @param \Callable $equals
 * --> with signature function(var1, var2): bool
 * --> equality is assumed to be transitive
 */
function groupByEquality($list, callable $equals): array
{
    $result = [];
    foreach ($list as $var)
    {
        foreach($result as &$group)
        {
            if (call_user_func($equals, $group[0], $var))
            {
                $group[] = $var;
                continue 2;
            }
        }
        $result[] = [$var]; // create a new group
    }
    return $result;
}

/**
 * Can be used to detect e.g. sentinel values where the sentinal indicates that this is the FIRST element of the group
 */
function groupUntil($list, callable $predicate): array
{
    $groups = [];
    $groupIndex = -1;

    foreach ($list as $item) {
        if ($predicate($item)) {
            // create new group
            $groupIndex++;
            $groups[$groupIndex] =  [];
        }
        // append to group
        $groups[$groupIndex][] = $item;
    }

    return $groups;
}

/**
 * Can be used to detect e.g. sentinel values where the sentinal indicates that this is the LAST element of the group
 */
protected function groupUntilInclusive($list, callable $predicate)
{
    $groups = [];

    if (count($list) > 0) {
        // create the first group
        $groups[] =  [];
    }

    $groupIndex = 0;
    foreach ($list as $item) {
        // append to group
        $groups[$groupIndex][] = $item;

        if ($predicate($item)) {
            // create new group
            $groupIndex++;
        }
    }

    return $groups;
}

function groupUntilByEquality(array $list, callable $equals)
{
    $list = array_values($list);

    $groups = [];
    $groupIndex = -1;

    foreach ($list as $i => $item) {
        if ($i !== 0 && $equals($list[$i - 1], $item)) {
            $groups[$groupIndex][] = $item;
        } else {
            $groupIndex++;
            $groups[$groupIndex] = [$item];
        }
    }

    return $groups;
}

function groupUntilGroupInvalid($list, callable $isValidGroup)
{
    $groups = [];

    if (count($list) > 0) {
        // create the first group
        $groups[] =  [];
    }

    $groupIndex = 0;

    foreach ($list as $item) {
        $appended = array_merge($groups[$groupIndex], [$item]);
        if ($isValidGroup($appended)) {
            $groups[$groupIndex] = $appended;
            continue;
        }

        if (count($appended) === 1) {
            throw new \RuntimeException('groupUntilGroupInvalid: cannot group this element because it forms an invalid group on its own');
        }

        $groupIndex++;
        $groups[$groupIndex] = [$item];
    }

    return $groups;
}
