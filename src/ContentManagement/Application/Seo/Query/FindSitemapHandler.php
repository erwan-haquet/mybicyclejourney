<?php

namespace App\ContentManagement\Application\Seo\Query;

use App\ContentManagement\Domain\Seo\Model\Sitemap\Sitemap;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use Library\CQRS\Query\QueryHandlerInterface;

class FindSitemapHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function __invoke(FindSitemap $query): Sitemap
    {
        $pages = $this->pageRepository->findIndexables();
        
        return Sitemap::new($pages);
    }
}
