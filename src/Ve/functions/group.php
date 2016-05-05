<?php

namespace Ve;

/**
 * @var objects array|traversable of objects
 * @var $properties property to group by.
 * 			If multiple are given they are treated as nested properties ($obj->prop1->prop2->prop3)
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
