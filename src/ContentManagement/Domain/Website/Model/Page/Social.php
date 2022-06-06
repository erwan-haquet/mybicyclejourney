<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Social\OpenGraph;
use Doctrine\ORM\Mapping as ORM;

/**
 * Social network sharing data.
 */
#[ORM\Embeddable]
class Social
{
    #[ORM\Embedded(class: OpenGraph::class)]
    private OpenGraph $openGraph;

    public function __construct(OpenGraph $openGraph)
    {
        $this->openGraph = $openGraph;
    }

    public function openGraph(): OpenGraph
    {
        return $this->openGraph;
    }
}
