<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The name of the document's author.
 */
#[ORM\Entity]
class Author extends Meta
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
            '<meta name="author" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'name_author';
    }
}
