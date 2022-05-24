<?php

namespace Library\CQRS\Query;

use RuntimeException;

/**
 * Default query implementation.
 */
abstract class Query implements QueryInterface
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (!\property_exists($this, $key)) {
                $parts = explode('\\', get_class($this));
                $query = str_replace('Query', '', end($parts));

                throw new RuntimeException(sprintf('Property "%s" is not a valid property on query "%s".', $key, $query));
            }
            $this->{$key} = $value;
        }
    }
}
