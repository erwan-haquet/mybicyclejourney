<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The name of the application running in the web page.
 */
#[ORM\Entity]
class ApplicationName extends Meta
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
            '<meta name="application-name" content="%s">',
            $this->content
        );
    }

    public function getType(): string
    {
        return 'name_application_name';
    }
}
