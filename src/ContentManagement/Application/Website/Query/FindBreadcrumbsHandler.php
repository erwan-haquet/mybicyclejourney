<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Exception\PageNotFound;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs\Breadcrumbs;
use Library\CQRS\Query\QueryHandlerInterface;

class FindBreadcrumbsHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @throws PageNotFound
     */
    public function __invoke(FindBreadcrumbs $query): Breadcrumbs
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            throw PageNotFound::forPath($query->path);
        }

        return Breadcrumbs::new($page);
    }
}
