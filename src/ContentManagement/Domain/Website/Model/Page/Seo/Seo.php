<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Seo;

/**
 * SEO concerns data.
 */
class Seo
{
    private CrawlPriority $crawlPriority;

    /**
     * Indicate if the page should be indexed or not by search engines.
     */
    private bool $shouldIndex;

    public function __construct(
        ?CrawlPriority $crawlPriority,
        ?bool $shouldIndex,
    )
    {
        $this->crawlPriority = $crawlPriority ?? CrawlPriority::new(30);
        $this->shouldIndex = $shouldIndex ?? true;
    }

    public function crawlPriority(): CrawlPriority
    {
        return $this->crawlPriority;
    }
    
    public function shouldIndex(): bool
    {
        return $this->shouldIndex;
    }
}
