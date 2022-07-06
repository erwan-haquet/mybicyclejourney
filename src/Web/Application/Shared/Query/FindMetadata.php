<?php

namespace App\Web\Application\Shared\Query;

use App\Web\Ui\Shared\Seo\Dto\Metadata\Metadata;
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
