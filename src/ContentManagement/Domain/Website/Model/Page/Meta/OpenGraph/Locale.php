<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The locale these tags are marked up in. Of the format language_TERRITORY.
 * Default is en_US.
 */
#[ORM\Entity]
class Locale extends Meta
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
            '<meta property="og:locale" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'og_locale';
    }
}
