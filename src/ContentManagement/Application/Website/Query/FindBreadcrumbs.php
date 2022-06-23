<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs\BreadcrumbsDto;
use Library\CQRS\Query\Query;

/**
 * Finds the breadcrumbs corresponding to given page path.
 * @see Breadcrumbs
 */
class FindBreadcrumbs extends Query
{
    public string $path;
}
