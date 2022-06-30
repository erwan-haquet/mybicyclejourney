<?php

namespace App\ContentManagement\Application\Components\Query;

use Library\CQRS\Query\Query;

/**
 * Finds the breadcrumbs corresponding to given page path.
 * @see Breadcrumbs
 */
class BuildBreadcrumbs extends Query
{
    public string $path;
}
