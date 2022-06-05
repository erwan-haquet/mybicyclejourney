<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The type of your object, e.g., "video.movie".
 * Depending on the type you specify, other properties may also be required.
 *
 * @see https://ogp.me/#types
 */
#[ORM\Entity]
class Type extends Meta
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
            '<meta property="og:type" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_type';
    }
}
