<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routing context of the page.
 */
#[ORM\Embeddable]
class Route
{
    #[ORM\Column(type: 'string')]
    private string $name;
    
    #[ORM\Column(type: 'string')]
    private string $path;
    
    #[ORM\Column(type: 'string')]
    private string $url;

    public function __construct(
        string $name,
        string $path,
        string $url,
    )
    {
        $this->name = $name;
        $this->path = $path;
        $this->url = $url;
    }

    /**
     * The name of the page in routing context.
     * Eg: `blog_article`
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * The relative url path.
     * Eg: `/blog/a-cool-article`
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * The absolute url to the page.
     * Eg: `https://mybicyclejourney.com/blog/a-cool-article`
     */
    public function url(): string
    {
        return $this->url;
    }
}
