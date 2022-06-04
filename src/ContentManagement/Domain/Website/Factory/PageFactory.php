<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Meta;
use App\ContentManagement\Domain\Website\Model\Page\Meta\MetaInterface;
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
        Title           $title,
        Type            $type,
        Path            $path,
        ?Page           $parent,
        Seo             $seo = new Seo,
        Meta\Collection $metas = new Meta\Collection
    ): Page
    {
        return new Page(
            id: $this->repository->nextIdentity(),
            title: $title,
            type: $type,
            path: $path,
            parent: $parent,
            seo: $seo,
            metas: $metas->merge($this->defaultMetas()),
        );
    }

    /**
     * @return MetaInterface[]
     */
    private function defaultMetas(): array
    {
        return [
            Meta\OpenGraph\Locale::new('fr_fr'),
            Meta\OpenGraph\Type::new('website'),
            Meta\OpenGraph\Url::new($this->request->getUri()),
            Meta\OpenGraph\SiteName::new('My Bicycle Journey '),
            Meta\Name\Viewport::new('width=device-width, initial-scale=1, shrink-to-fit=no'),
        ];
    }
}
