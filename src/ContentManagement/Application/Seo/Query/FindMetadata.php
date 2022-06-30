<?php

namespace App\ContentManagement\Application\Seo\Query;

use App\ContentManagement\Domain\Seo\Model\Metadata\Metadata;
use Library\CQRS\Query\Query;

/**
 * Finds the page metadata corresponding to given path.
 *
 * @see Metadata
 */
class FindMetadata extends Query
{
    public string $path;
}
