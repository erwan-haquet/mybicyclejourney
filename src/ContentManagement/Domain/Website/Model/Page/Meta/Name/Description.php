<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * A short and accurate summary of the content of the page.
 * Several browsers, like Firefox and Opera, use this as the default description of bookmarked pages.
 */
#[ORM\Entity]
class Description extends Meta 
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;

    /**
     * The recommended meta description length is 920 pixels
     * or roughly 155 characters or fewer including spaces
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="description" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'name_description';
    }
}
