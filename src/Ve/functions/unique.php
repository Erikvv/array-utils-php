<?php

namespace Ve;

/*
 * removes duplicate elements from an array
 * similar to the builtin "array_unique" but with a user defined compare function
 */
function u_array_unique(array $array, callable $equals): array
{
	$result = [];

	foreach($array as $row)
	{
		if( u_in_array($result, $row, $equals) )
		{
			continue;
		}
		else
		{
			$result[] = $row;
		}
	}

	return $result;
}

/*
 * removes duplicate elements from an array based on a property
 * the property must be a string-ish property
 *
 * When is this useful?
 */
function array_unique_property(array $objects, $property): array
{
	$result = [];

	foreach($objects as $obj)
	{
		$result[$obj->$property] = $obj;
	}

	return array_values($result);
}
