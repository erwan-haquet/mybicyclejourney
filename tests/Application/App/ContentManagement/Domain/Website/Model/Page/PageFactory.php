<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Crawl;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\Uid\Uuid;

class PageFactory
{
    public static function new(
        ?PageId $id = null,
        ?string $title = null,
        ?string $description = null,
        ?string $label = null,
        ?Locale $locale = null,
        ?Page   $parent = null,
        ?Route  $route = null,
        ?Crawl  $crawl = null,
        ?string $imageUrl = null,
    ): Page
    {
        return new Page(
            id: $id ?? PageId::fromString(Uuid::v4()),
            route: $route ?? new Route(
                name: $name ?? "",
                path: $path ?? "",
                url: $url ?? ""
            ),
            title: $title ?? "",
            description: $description ?? "",
            label: $label ?? "",
            imageUrl: $imageUrl,
            locale: $locale ?? new Locale('EN'),
            parent: $parent,
            crawl: $crawl
        );
    }
}
