<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta;

use Library\Assert\Assert;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * Regroups all the metadata for a unique page and guarantee the html meta
 * structure to be valid (avoid non-valid multiple definition of same meta...).
 */
class Collection implements IteratorAggregate
{
    /**
     * @var array|Meta[]
     */
    private array $metas = [];

    public function __construct(array $metas = [])
    {
        Assert::allIsInstanceOf($metas, Meta::class);

        foreach ($metas as $meta) {
            $this->add($meta);
        }
    }

    public function add(Meta $meta): self
    {
        $this->metas[] = $meta;
        return $this;
    }

    /**
     * Merge given metas into current ones.
     */
    public function merge(iterable $metas): self
    {
        Assert::allIsInstanceOf($metas, Meta::class);

        foreach ($metas as $meta) {
            $this->add($meta);
        }

        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->metas);
    }
    
    public function toArray(): array
    {
        return $this->metas;
    }
}
