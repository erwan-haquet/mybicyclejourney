<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;
use Library\Assert\Assert;

/**
 * SEO concerns data.
 */
#[ORM\Embeddable]
class Seo
{
    /**
     * A value between 0.1 and 1 to indicate to the crawler how the page should
     * be frequently re-crawl. The higher you rank a page, the more often it
     * will be crawled by search engines and vice versa.
     *
     * Value is stored as integer to prevent float approximation.
     *
     * @see https://seodesignchicago.com/seo-blog/6-sitemap-best-practices/#1_-_Prioritize_Your_Web_Pages
     */
    #[ORM\Column(type: 'integer')]
    private int $crawlPriority;

    /**
     * Indicate if the page should be indexed or not by search engines.
     */
    #[ORM\Column(type: 'boolean')]
    private bool $shouldIndex = true;

    public function __construct(
        ?float $crawlPriority = null,
        ?bool  $shouldIndex = true,
    )
    {
        Assert::nullOrRange($crawlPriority, 0.1, 1);
        $this->crawlPriority = $crawlPriority ? $crawlPriority * 10 : 5;

        $this->shouldIndex = $shouldIndex;
    }

    public function crawlPriority(): float
    {
        return $this->crawlPriority / 10;
    }

    public function shouldIndex(): bool
    {
        return $this->shouldIndex;
    }
}
