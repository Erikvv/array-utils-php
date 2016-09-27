<?php

function values(array $source, array $keys): array
{
    $result = [];

    foreach ($keys as $key) {
        $result[] = $source[$key];
    }

    return $result;
}
