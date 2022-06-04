<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use App\ContentManagement\Domain\Website\Model\Page\Meta\MetaInterface;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * The basic meta tag, used on every website to indicate primary information.
 *
 * The <meta> element can be used to provide document metadata in terms of name-value
 * pairs, with the name attribute giving the metadata name,
 * and the content attribute giving the value.
 *
 * @see https://developer.mozilla.org/en/docs/Web/HTML/Element/meta#attr-name
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta/name
 */
abstract class MetaName implements MetaInterface, JsonSerializable
{
    protected string $name;
    protected string $content;

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="%s" content="%s">',
            $this->name, $this->content
        );
    }

    #[ArrayShape(['type' => "string", 'name' => "string", 'content' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'type' => 'meta_name',
            'name' => $this->name,
            'content' => $this->content
        ];
    }
}
