<?php

namespace Library\Utils;

/**
 * Convenience View that helps with construction by mapping an array input
 * to view properties. If a passed property does not exist on the class,
 * it is simply ignored.
 */
abstract class View
{
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (\property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
