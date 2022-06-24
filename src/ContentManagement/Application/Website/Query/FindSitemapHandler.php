<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Sitemap\SitemapDto;
use Library\CQRS\Query\QueryHandlerInterface;

class FindSitemapHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function __invoke(FindSitemap $query): SitemapDto
    {
        $pages = $this->pageRepository->findIndexables();
        
        return SitemapDto::new($pages);
    }
}
