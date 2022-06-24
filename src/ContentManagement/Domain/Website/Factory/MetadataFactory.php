<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata\LocaleAlternateDto;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata\MetadataDto;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata\OpenGraphDto;
use DusanKasan\Knapsack\Collection;

class MetadataFactory
{
    protected PageRepositoryInterface $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function create(Page $page): MetadataDto
    {
        return new MetadataDto([
            'title' => $page->title(),
            'description' => $page->description(),
            'noindex' => !$page->seo()->shouldIndex(),
            'nofollow' => !$page->seo()->shouldIndex(),
            'localeAlternates' => $this->localeAlternates($page),
            'canonicalUrl' => $page->url(),
            'openGraph' => new OpenGraphDto([
                'title' => $page->social()->openGraph()->title(),
                'description' => $page->social()->openGraph()->description(),
                'image' => $page->social()->openGraph()->image(),
                'localeAlternates' => $this->localeAlternates($page),
                'canonicalUrl' => $page->url(),
            ])
        ]);
    }

    /**
     * Retrieves the alternate language pages based on the current one.
     *
     * @return LocaleAlternateDto[]
     */
    private function localeAlternates(Page $page): array
    {
        $pages = $this->repository->findLocaleAlternates($page->id());

        return Collection::from($pages)
            ->map(function (Page $page) {
                return new LocaleAlternateDto([
                    'locale' => $page->locale(),
                    'url' => $page->url(),
                ]);
            })
            ->toArray();
    }
}
