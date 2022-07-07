<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Metadata\LocaleAlternate;
use App\ContentManagement\Domain\Website\Model\Metadata\Metadata;
use App\ContentManagement\Domain\Website\Model\Metadata\OpenGraph;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use loophp\collection\Collection;

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
        $localeAlternates = Collection::fromIterable($localeAlternatePages)
            ->map(fn(Page $page) => new LocaleAlternate([
                'locale' => $page->locale(),
                'url' => $page->url(),
            ]))
            ->all();

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
