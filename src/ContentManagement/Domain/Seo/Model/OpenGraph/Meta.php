<?php

namespace App\ContentManagement\Domain\Seo\Model\OpenGraph;

/**
 * The Open Graph protocol enables any web page to become a rich object
 * in a social graph. For instance, this is used on Facebook to allow any
 * web page to have the same functionality as any other object on Facebook.
 *
 * @see https://ogp.me/
 */
abstract class Meta
{
    private string $property;
    private string $content;

    public function __construct(string $property, string $content)
    {
        $this->property = $property;
        $this->content = $content;
    }
    
    public function render(): string
    {
        return sprintf(
            '<meta property="og:%s" content="%S">',
            $this->property, $this->content
        );
    }
}
