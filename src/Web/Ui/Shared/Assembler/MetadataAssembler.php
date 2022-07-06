<?php

namespace App\Web\Ui\Shared\Assembler;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Web\Ui\Shared\Dto\Metadata\LocaleAlternate;
use App\Web\Ui\Shared\Dto\Metadata\Metadata;
use App\Web\Ui\Shared\Dto\Metadata\OpenGraph;
use loophp\collection\Collection;

class MetadataAssembler
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
