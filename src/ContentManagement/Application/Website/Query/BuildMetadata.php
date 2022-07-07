<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Model\Metadata\Metadata;
use Library\CQRS\Query\Query;

/**
 * Finds the page metadata corresponding to given path.
 *
 * @see Metadata
 */
class BuildMetadata extends Query
{
    public string $path;
}
