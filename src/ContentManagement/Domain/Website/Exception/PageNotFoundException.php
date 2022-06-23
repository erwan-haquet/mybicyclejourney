<?php

namespace App\ContentManagement\Domain\Website\Exception;

class PageNotFoundException extends \Exception
{
    public static function forPath(string $path): self
    {
        $message = sprintf(
            'The page with given path "%s" cannot be found',
            $path,
        );

        return new self($message);
    }
}
