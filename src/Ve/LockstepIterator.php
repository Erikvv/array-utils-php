<?php

namespace Ve;

use Iterator;

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
        // TODO: refactor using object map function
        return array_map(function(Iterator $it) { return $it->current(); }, $this->iterators);
    }

    public function key(): int
    {
        return $counter;
    }

    public function next()
    {
        // TODO: refactor using object map function
        array_map(function(Iterator $it) { $it->next(); }, $this->iterators);
        $this->counter++;
        return;
    }

    public function rewind()
    {
        // TODO: refactor using rest of library
        array_map(function(Iterator $it) { $it->rewind(); }, $this->iterators);
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
