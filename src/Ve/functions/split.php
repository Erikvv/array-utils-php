<?php 

namespace Ve;

/**
 * split a list into a head and tail
 */
function headTail(array $list) {
    assert(count($list) > 0);
    
    return [
        $array[0],
        array_slice($array, 1),
    ];
}
