<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The browser's viewport is the area of the window in which web content
 * can be seen. This is often not the same size as the rendered page,
 * in which case the browser provides scrollbars for the user to scroll
 * around and access all the content.
 */
#[ORM\Entity]
class Viewport extends Meta
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
            '<meta name="viewport" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'name_viewport';
    }
}
