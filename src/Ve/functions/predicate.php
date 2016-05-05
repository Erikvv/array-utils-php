<?php

namespace Ve;

function doAllSatisfy($objects, $predicateMethod): bool
{
	foreach ($objects as $obj)
	{
		if (! $obj->$predicateMethod()) {
			return false;
		}
	}
	return true;
}


/**
 * check if all required keys exist in the source array
 */
function array_keys_exist(array $data, ...$requiredKeys): bool
{
	$commonKeys = array_intersect( array_keys($data), $requiredKeys);

	return array_diff($commonKeys, $requiredKeys) === [];
}

/*
 * Checks if element is present in array
 * similar to the builtin "in_array" but with a user defined compare function
 */
function u_in_array($array, $outsideElement, callable $equals): bool
{
	foreach($array as $element)
	{
		if( call_user_func($equals, $element, $outsideElement) === true)
		{
			return true;
		}
	}

	return false;
}
