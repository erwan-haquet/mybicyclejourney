<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\OpenGraph;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\ContentManagement\Domain\Website\Model\Page\Seo;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\Uid\Uuid;

class PageFactory
{
    public static function new(
        ?PageId    $id = null,
        ?string    $title = null,
        ?string    $description = null,
        ?string    $label = null,
        ?Locale    $locale = null,
        ?Page      $parent = null,
        ?Route     $route = null,
        ?Seo       $seo = null,
        ?OpenGraph $openGraph = null,
    ): Page {

        return new Page(
            id: $id ?? PageId::fromString(Uuid::v4()),
            title: $title ?? '',
            description: $description ?? '',
            label: $label ?? '',
            locale: $locale ?? new Locale('FR'),
            route: $route ?? RouteFactory::new(),
            parent: $parent,
            seo: $seo,
            openGraph: $openGraph
        );
    }
}
