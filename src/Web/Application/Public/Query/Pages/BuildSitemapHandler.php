<?php

namespace App\Web\Application\Public\Query\Pages;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Web\Ui\Public\Pages\Dto\Sitemap\Sitemap;
use Library\CQRS\Query\QueryHandlerInterface;

class BuildSitemapHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function __invoke(BuildSitemap $query): Sitemap
    {
        $pages = $this->pageRepository->findIndexables();
        
        return Sitemap::new($pages);
    }
}
