<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Ui\Website\Web\Dto\Metadata\Metadata;
use Library\CQRS\Query\Query;

/**
 * Finds the page metadata corresponding to given path.
 * @see Metadata
 */
class FindMetadata extends Query
{
    public string $path;
}
