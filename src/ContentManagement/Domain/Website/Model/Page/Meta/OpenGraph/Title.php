<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The title of your object as it should appear within the graph, e.g., "The Rock".
 */
#[ORM\Entity]
class Title extends Meta
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
            '<meta property="og:title" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_title';
    }
}
