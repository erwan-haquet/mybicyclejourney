<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * A one to two sentence description of your object.
 */
#[ORM\Entity]
class Description extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;

    /**
     * SEO experts recommend that you do not go beyond the limit of 200 characters.
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }
    
    public function render(): string
    {
        return sprintf(
            '<meta property="og:description" content="%s">',
            $this->content
        );
    }
    
    public function getType(): string
    {
        return 'og_description';
    }
}
