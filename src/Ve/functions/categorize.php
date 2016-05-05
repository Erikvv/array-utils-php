<?php

namespace Ve;

/**
 * this function is for when the property is an object which should be compared by identity
 * (this could be doctrine entities with a many-to-one relation to a type table)
 *
 * You would not be able to use the "group" functions because an object cannot be a key in an associative array
 *
 * @param Traversable $objects
 * @param string $property to compare by object identity
 * @param string $collectionName key under which the objects will be stored in the category
 *
 * @return [
 * 		[
 * 			$propertyName   => $propertyValue
 * 			$collectionName => $categorizedObjects
 * 		]
 * 		...
 * ]
 */
function categorizeByPropertyIdentity($objects, string $property, string $collectionName = 'objects'): array
{
	$result = [];

	foreach ($objects as $obj)
	{
		foreach ($result as &$category)
		{
			if ($category[$property] === $obj->$property)
			{
                // add to existing category
				$category[$collectionName][] = $obj;
				continue 2;
			}
		}
        // create a new category
		$result[] = [
			$property       => $obj->$property,
			$collectionName => [$obj]
		];
	}

	return $result;
}
