<?php

namespace App\ContentManagement\Domain\Seo\Model;

/**
 * Brings together all the resources required to for rendering SEO tags. 
 */
class Page
{
    private string $title;

    /**
     * @var array<OpenGraph\Meta>
     */
    private array $openGraphMeta;

    /**
     * @var array<MetaName\Meta>
     */
    private array $metaNames;

    public function __construct(
        string $title,
        array  $openGraphMeta,
        array  $metaNames
    )
    {
        $this->title = $title;
        $this->openGraphMeta = $openGraphMeta;
        $this->metaNames = $metaNames;
    }
}
