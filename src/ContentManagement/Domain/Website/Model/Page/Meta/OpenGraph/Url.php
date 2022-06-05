<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The canonical URL of your object that will be used as its
 * permanent ID in the graph, e.g., "https://www.imdb.com/title/tt0117500/".
 */
#[ORM\Entity]
class Url extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render(): string
    {
        return sprintf(
            '<meta property="og:url" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_url';
    }
}
