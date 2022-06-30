<?php

namespace App\ContentManagement\Domain\Seo\Factory;

use App\ContentManagement\Domain\Seo\Model\LocaleAlternate;
use App\ContentManagement\Domain\Seo\Model\Metadata;
use App\ContentManagement\Domain\Seo\Model\OpenGraph;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use DusanKasan\Knapsack\Collection;

class MetadataFactory
{
    protected PageRepositoryInterface $repository;

    public function __construct(PageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function buildFromPage(Page $page): Metadata
    {
        $localeAlternatePages = $this->repository->findLocaleAlternates($page->id());
        $localeAlternates = Collection::from($localeAlternatePages)
            ->map(fn(Page $page) => new LocaleAlternate([
                'locale' => $page->locale(),
                'url' => $page->url(),
            ]))
            ->toArray();

        return new Metadata([
            'title' => $page->title(),
            'description' => $page->description(),
            'noindex' => !$page->shouldIndex(),
            'nofollow' => !$page->shouldIndex(),
            'localeAlternates' => $localeAlternates,
            'canonicalUrl' => $page->url(),
            'openGraph' => new OpenGraph([
                'title' => $page->title(),
                'description' => $page->description(),
                'locale' => $page->locale()->language(),
                'image' => $page->imageUrl(),
                'localeAlternates' => $localeAlternates,
                'url' => $page->url(),
            ])
        ]);
    }

    public function build404error(): Metadata
    {
        return new Metadata([
            'title' => 'Page not found - MyBicycleJourney',
            'description' => 'Oops we are lost :/',
            'noindex' => true,
            'nofollow' => true
        ]);
    }
}
