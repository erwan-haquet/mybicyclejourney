<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * An image URL which should represent your object within the graph.
 */
#[ORM\Entity]
class Image extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;

    /**
     * Image recommandation is 1200x630px with a maximum of 1MB.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render(): string
    {
        return sprintf(
            '<meta property="og:image" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_image';
    }
}
