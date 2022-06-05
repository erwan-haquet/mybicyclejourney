<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * If your object is part of a larger website,
 * the name which should be displayed for the overall site. e.g., "IMDb".
 */
#[ORM\Entity]
class SiteName extends Meta
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
            '<meta property="og:site_name" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_site_name';
    }
}
