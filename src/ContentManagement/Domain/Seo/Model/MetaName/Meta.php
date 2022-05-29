<?php

namespace App\ContentManagement\Domain\Seo\Model\MetaName;

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
abstract class Meta
{
    private string $type;
    private string $content;

    public function __construct(string $type, string $content)
    {
        $this->type = $type;
        $this->content = $content;
    }
    
    public function render(): string
    {
        return sprintf(
            '<meta name="%s" content="%S">',
            $this->type, $this->content
        );
    }
}
