<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\OpenGraph;

class OpenGraphFactory
{
    public static function new(
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
    ): OpenGraph
    {
        return new OpenGraph(
            title: $title,
            description: $description,
            image: $image,
        );
    }
}
