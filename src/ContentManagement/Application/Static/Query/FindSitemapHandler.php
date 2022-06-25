<?php

namespace App\ContentManagement\Application\Static\Query;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Static\Web\Dto\Sitemap\SitemapDto;
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
