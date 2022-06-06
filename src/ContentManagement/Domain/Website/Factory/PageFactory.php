<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\ContentManagement\Domain\Website\Model\Page\Seo;
use App\ContentManagement\Domain\Website\Model\Page\Social;
use App\ContentManagement\Domain\Website\Model\Page\Type;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Supporting\Domain\I18n\Model\Locale;

class PageFactory
{
    protected PageRepositoryInterface $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Creates a new page with default configuration properties.
     */
    public function create(
        Type   $type,
        string $title,
        string $description,
        Locale $locale,
        ?Page  $parent,
        Route  $route,
        Seo    $seo = null,
        Social $social = null,
    ): Page
    {
        $seo = $seo ?? new Seo();
        $social = $social ?? new Social(
                openGraph: new Social\OpenGraph()
            );

        return new Page(
            id: $this->repository->nextIdentity(),
            title: $title,
            description: $description,
            locale: $locale,
            type: $type,
            route: $route,
            parent: $parent,
            seo: $seo,
            social: $social
        );
    }
}
