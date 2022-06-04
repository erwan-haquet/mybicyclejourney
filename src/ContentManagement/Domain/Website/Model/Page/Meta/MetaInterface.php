<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta;

/**
 * @see https://developer.mozilla.org/docs/Web/HTML/Element/meta
 */
interface MetaInterface
{
    /**
     * Render the tag to display in html <head>.
     * 
     * eg: '<meta name="description" content="A super cool website for bikers">'
     */
    public function render(): string;
}
