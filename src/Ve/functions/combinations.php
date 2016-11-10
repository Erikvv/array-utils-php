<?php

/**
 * Variadic-ish recursive function which returns all combinations of the input list (like unconditional join in SQL)
 *
 * Calling the function with no input lists or an empty input list is an invalid operation
 */
public function combinations(array $lists, array $resultCombinations = [[]])
{
    // input assertions
    foreach ($lists as $list) {
        Assert::isArray($list);
        Assert::notEmpty($list);
    }

    if (empty($lists)) { // recursion end condition
        // output assertions
        Assert::notEmpty($resultCombinations);
        foreach ($resultCombinations as $combination) {
            Assert::notEmpty($combination);
        }
        return $resultCombinations;
    }

    // begin of implementation
    $currentList = array_shift($lists);

    $resultCombinations = \Functional\flat_map($resultCombinations, function (array $combination) use ($currentList) {
        return \Functional\map($currentList, function ($element) use ($combination) {
            return array_merge($combination, [$element]);
        });
    });

    return $this->combinations($lists, $resultCombinations);
}
