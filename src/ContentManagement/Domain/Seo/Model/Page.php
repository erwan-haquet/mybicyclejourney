<?php

namespace App\ContentManagement\Domain\Seo\Model;

/**
 * Brings together all the resources required for rendering SEO tags.
 */
class Page
{
    private Title $title;

    /**
     * @var array<OpenGraph\Meta>
     */
    private array $openGraphMeta;

    /**
     * @var array<MetaName\Meta>
     */
    private array $nameMeta;

    public function __construct(
        Title $title,
        array $openGraphMeta = [],
        array $nameMeta = []
    )
    {
        $this->title = $title;
        $this->openGraphMeta = $openGraphMeta;
        $this->nameMeta = $nameMeta;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function addOGMeta(OpenGraph\Meta $meta): self
    {
        $this->openGraphMeta[] = $meta;
        return $this;
    }
    
    public function addNameMeta(OpenGraph\Meta $meta): self
    {
        $this->openGraphMeta[] = $meta;
        return $this;
    }

    /**
     * @return OpenGraph\Meta[]
     */
    public function openGraph(): array
    {
        return $this->openGraphMeta;
    }

    /**
     * @return MetaName\Meta[]
     */
    public function nameMeta(): array
    {
        return $this->nameMeta;
    }
}
