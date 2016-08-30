<?php

namespace Ve;

use Iterator;

/**
 * Allows iteratation over multiple iterators in lockstep
 * To use it on arrays, wrap the array in an SPL ArrayIterator
 * Iteration stops when any one of the source iterators has run out
 */
class LockstepIterator implements Iterator
{
    /** @var array */
    private $iterators;
    private $counter = 0;

    public function __construct(Iterator ...$iterators)
    {
        $this->iterators = $iterators;
    }

    public function current(): array
    {
        return map($this->iterators, 'current');
    }

    public function key(): int
    {
        return $counter;
    }

    public function next()
    {
        map($this->iterators, 'next');
        $this->counter++;
        return;
    }

    public function rewind()
    {
        map($this->iterators, 'rewind');
        $this->counter = 0;
        return;
    }

    public function valid(): bool
    {
        foreach ($this->iterators as $it) {
            if (!$it->valid()) {
                return false;
            }
        }
        return true;
    }
}
