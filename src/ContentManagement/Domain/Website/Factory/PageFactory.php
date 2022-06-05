<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Meta;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\ContentManagement\Domain\Website\Model\Page\Seo\Seo;
use App\ContentManagement\Domain\Website\Model\Page\Title;
use App\ContentManagement\Domain\Website\Model\Page\Type;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PageFactory
{
    protected Request $request;
    protected PageRepositoryInterface $repository;

    public function __construct(
        RequestStack            $requestStack,
        PageRepositoryInterface $repository
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->repository = $repository;
    }

    /**
     * Creates a new page with default configuration properties.
     */
    public function create(
        Type   $type,
        Title  $title,
        Locale $locale,
        ?Page  $parent,
        Route  $route,
        Seo    $seo = new Seo,
        array  $metas = []
    ): Page
    {
        $page = new Page(
            id: $this->repository->nextIdentity(),
            locale: $locale,
            title: $title,
            type: $type,
            route: $route,
            parent: $parent,
            seo: $seo,
        );

        $page = $this->buildDefaultMetas($page);

        foreach ($metas as $meta) {
            $page->addMeta($meta);
        }

        return $page;
    }

    private function buildDefaultMetas(Page $page): Page
    {
        $page
            ->addMeta(new Meta\OpenGraph\Type('website'))
            ->addMeta(new Meta\OpenGraph\SiteName('My Bicycle Journey'))
            ->addMeta(new Meta\OpenGraph\Url($page->url()))
            ->addMeta(new Meta\OpenGraph\Locale((string)$page->locale()));

        return $page;
    }
}
