<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Meta;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\Path;
use App\ContentManagement\Domain\Website\Model\Page\Seo\Seo;
use App\ContentManagement\Domain\Website\Model\Page\Title;
use App\ContentManagement\Domain\Website\Model\Page\Type;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
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
        Title $title,
        Type  $type,
        Path  $path,
        ?Page $parent,
        Seo   $seo = new Seo,
        array $metas = []
    ): Page
    {
        $page = new Page(
            id: $this->repository->nextIdentity(),
            title: $title,
            type: $type,
            path: $path,
            parent: $parent,
            seo: $seo,
        );

        foreach ($this->defaultMetas() as $defaultMeta) {
            $page->addMeta($defaultMeta);
        }

        foreach ($metas as $meta) {
            $page->addMeta($meta);
        }

        return $page;
    }

    /**
     * @return Meta\Meta[]
     */
    private function defaultMetas(): array
    {
        return [
            new Meta\OpenGraph\Locale('fr_fr'),
            new Meta\OpenGraph\Type('website'),
            new Meta\OpenGraph\Url($this->request->getUri()),
            new Meta\OpenGraph\SiteName('My Bicycle Journey '),
            new Meta\Name\Viewport('width=device-width, initial-scale=1, shrink-to-fit=no'),
        ];
    }
}
