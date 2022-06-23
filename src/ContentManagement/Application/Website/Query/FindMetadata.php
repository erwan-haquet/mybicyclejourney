<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Ui\Website\Web\Dto\Metadata\MetadataDto;
use Library\CQRS\Query\Query;

/**
 * Finds the page metadata corresponding to given path.
 *
 * @see MetadataDto
 */
class FindMetadata extends Query
{
    public string $path;
}
