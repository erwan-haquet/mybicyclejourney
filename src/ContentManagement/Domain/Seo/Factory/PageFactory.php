<?php

namespace App\ContentManagement\Domain\Seo\Factory;

use App\ContentManagement\Domain\Seo\Model\MetaName;
use App\ContentManagement\Domain\Seo\Model\OpenGraph;
use App\ContentManagement\Domain\Seo\Model\Page;
use App\ContentManagement\Domain\Seo\Model\Title;
use Library\Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PageFactory
{
    protected Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Creates a new page with default configuration properties.
     * *title* and *description* are required.
     */
    public function create(Title $title, array $nameMeta, array $openGraph): Page
    {
        Assert::allIsInstanceOf($nameMeta, MetaName\Meta::class);
        Assert::allIsInstanceOf($openGraph, OpenGraph\Meta::class);
        
        return new Page(
            title: $title,
            openGraphMeta: [...$openGraph, ...$this->defaultOGMeta()],
            nameMeta: [...$nameMeta, ...$this->defaultNameMeta()],
        );
    }

    private function defaultNameMeta(): array
    {
        return [
            MetaName\Viewport::new('width=device-width, initial-scale=1, shrink-to-fit=no')
        ];
    }

    private function defaultOGMeta(): array
    {
        return [
            OpenGraph\Type::new('website'),
            OpenGraph\Locale::new('fr_fr'),
            OpenGraph\Url::new($this->request->getUri()),
            OpenGraph\SiteName::new('My Bicycle Journey '),
        ];
    }
}
