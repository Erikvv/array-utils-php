<?php 

namespace Ve;

/**
 * split a list into a head and tail
 */
function headTail(array $list) {
    assert(count($list) > 0);
    
    return [
        $list[0],
        array_slice($list, 1),
    ];
}
