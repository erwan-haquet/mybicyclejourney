<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Components\Web\Dto\Breadcrumbs\BreadcrumbsDto;
use Library\CQRS\Query\QueryHandlerInterface;

class BuildBreadcrumbsHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @throws PageNotFoundException
     */
    public function __invoke(BuildBreadcrumbs $query): BreadcrumbsDto
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            throw PageNotFoundException::forPath($query->path);
        }

        return BreadcrumbsDto::new($page);
    }
}
