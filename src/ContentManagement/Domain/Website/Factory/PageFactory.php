<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\OpenGraph;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\ContentManagement\Domain\Website\Model\Page\Seo;
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
        string     $title,
        string     $description,
        string     $label,
        Route      $route,
        Locale     $locale,
        ?Page      $parent,
        ?Seo       $seo = null,
        ?OpenGraph $og = null,
    ): Page {
        return new Page(
            id: $this->repository->nextIdentity(),
            title: $title,
            description: $description,
            label: $label,
            locale: $locale,
            route: $route,
            parent: $parent,
            seo: $seo,
            openGraph: $og
        );
    }
}
