<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;

use App\ContentManagement\Domain\Website\Model\Page\Meta\MetaInterface;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * The Open Graph protocol enables any web page to become a rich object
 * in a social graph. For instance, this is used on Facebook to allow any
 * web page to have the same functionality as any other object on Facebook.
 *
 * @see https://ogp.me/
 */
abstract class OpenGraph implements MetaInterface, JsonSerializable
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
            '<meta property="og:%s" content="%s">',
            $this->property, $this->content
        );
    }

    #[ArrayShape(['type' => "string", 'property' => "string", 'content' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'type' => 'open_graph',
            'property' => $this->property,
            'content' => $this->content
        ];
    }
}
