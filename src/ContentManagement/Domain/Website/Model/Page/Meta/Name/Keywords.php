<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * Words relevant to the page's content separated by commas.
 */
#[ORM\Entity]
class Keywords extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;


    public function __construct(array $values)
    {
        $this->content = implode(', ', $values);
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="keywords" content="%s">',
            $this->content
        );
    }
    
    public function getType(): string
    {
        return 'name_keywords';
    }
}
