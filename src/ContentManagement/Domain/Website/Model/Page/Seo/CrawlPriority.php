<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Seo;

use Library\Assert\Assert;

/**
 * A value between 0.1 and 1 to indicate to the crawler how the page should
 * be frequently re-crawl. The higher you rank a page, the more often it
 * will be crawled by search engines and vice versa.
 *
 * @see https://seodesignchicago.com/seo-blog/6-sitemap-best-practices/#1_-_Prioritize_Your_Web_Pages
 */
class CrawlPriority
{
    private float $value;

    public function __construct(float $value)
    {
        Assert::range($value, 0.1, 1);
        
        $this->value = $value;
    }

    /**
     * Instantiate from a percentage.
     */
    public static function new(int $percent): CrawlPriority
    {
        Assert::range($percent, 1, 100);

        return new self($percent / 100);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
