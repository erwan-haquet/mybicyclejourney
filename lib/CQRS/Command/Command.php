<?php

namespace Library\CQRS\Command;

use RuntimeException;

/**
 * Default synchronous command implementation.
 */
abstract class Command implements CommandInterface
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (!\property_exists($this, $key)) {
                $parts = explode('\\', get_class($this));
                $command = str_replace('Command', '', end($parts));

                throw new RuntimeException(sprintf('Property "%s" is not a valid property on command "%s".', $key, $command));
            }
            $this->{$key} = $value;
        }
    }
}
