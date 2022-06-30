<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;
use Library\Assert\Assert;

/**
 * Robot crawling concerns.
 */
#[ORM\Embeddable]
class Crawl
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
    private int $priority;

    /**
     * Indicate if the page should be indexed or not by search engines.
     */
    #[ORM\Column(type: 'boolean')]
    private bool $shouldIndex;

    public function __construct(
        float $priority = 0.5,
        bool  $shouldIndex = true,
    )
    {
        Assert::nullOrRange($priority, 0.1, 1);
        $this->priority = $priority * 10;

        $this->shouldIndex = $shouldIndex;
    }

    /**
     * Default standard value.
     */
    public static function default(): self
    {
        return new self(
            priority: 0.5,
            shouldIndex: true
        );
    }

    public function priority(): float
    {
        return $this->priority / 10;
    }

    public function setPriority(float $priority): float
    {
        return $this->priority = $priority * 10;
    }

    public function shouldIndex(): bool
    {
        return $this->shouldIndex;
    }
}
