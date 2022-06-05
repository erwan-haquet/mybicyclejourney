<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Seo;

use Doctrine\ORM\Mapping as ORM;

/**
 * SEO concerns data.
 */
#[ORM\Embeddable]
class Seo
{
    #[ORM\Embedded(class: CrawlPriority::class)]
    private CrawlPriority $crawlPriority;

    /**
     * Indicate if the page should be indexed or not by search engines.
     */
    #[ORM\Column(type: 'boolean')]
    private bool $shouldIndex;

    public function __construct(
        CrawlPriority $crawlPriority = null,
        bool          $shouldIndex = true,
    )
    {
        $this->crawlPriority = $crawlPriority ?? new CrawlPriority(0.3);
        $this->shouldIndex = $shouldIndex;
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
