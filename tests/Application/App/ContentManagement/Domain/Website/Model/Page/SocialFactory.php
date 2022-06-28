<?php

namespace Tests\Application\App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Social;

class SocialFactory
{
    public static function new(
        ?Social\OpenGraph $openGraph = null,
    ): Social {
        return new Social(
            openGraph: $openGraph ?? self::newOpenGraph()
        );
    }

    public static function newOpenGraph(
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
    ): Social\OpenGraph
    {
        return new Social\OpenGraph(
            title: $title,
            description: $description,
            image: $image,
        );
    }
}
