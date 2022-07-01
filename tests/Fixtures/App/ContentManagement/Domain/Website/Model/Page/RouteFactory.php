<?php

namespace Tests\Fixtures\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Route;

class RouteFactory
{
    public static function new(
        ?string $name = null,
        ?string $path = null,
        ?string $url = null,
    ): Route {
        return new Route(
            name: $name ?? "",
            path: $path ?? "",
            url: $url ?? ""
        );
    }
}
