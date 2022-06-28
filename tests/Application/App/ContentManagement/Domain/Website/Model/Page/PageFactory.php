<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Model\Page\Route;
use App\ContentManagement\Domain\Website\Model\Page\Seo;
use App\ContentManagement\Domain\Website\Model\Page\Social;
use App\ContentManagement\Domain\Website\Model\Page\Type;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\Uid\Uuid;

class PageFactory
{
    public static function new(
        ?Type   $type = null,
        ?string $title = null,
        ?string $description = null,
        ?string $label = null,
        ?Locale $locale = null,
        ?Page   $parent = null,
        ?Route  $route = null,
        ?Seo    $seo = null,
        ?Social $social = null,
    ): Page {

        return new Page(
            id: PageId::fromString(Uuid::v4()),
            title: $title ?? "Default test title",
            description: $description ?? "A default test description",
            label: $label ?? "Homepage - test",
            locale: $locale ?? new Locale('FR'),
            type: $type ?? Type::Static,
            route: $route ?? RouteFactory::new(),
            parent: $parent ?? null,
            seo: $seo ?? SeoFactory::new(),
            social: $social ?? SocialFactory::new()
        );
    }
}
