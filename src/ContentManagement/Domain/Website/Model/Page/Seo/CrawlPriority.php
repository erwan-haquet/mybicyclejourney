<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Seo;

use Library\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A value between 0.1 and 1 to indicate to the crawler how the page should
 * be frequently re-crawl. The higher you rank a page, the more often it
 * will be crawled by search engines and vice versa.
 *
 * @see https://seodesignchicago.com/seo-blog/6-sitemap-best-practices/#1_-_Prioritize_Your_Web_Pages
 */
#[ORM\Embeddable]
class CrawlPriority
{
    /**
     * Value is stored as integer to prevent float approximation.
     */
    #[ORM\Column(type: 'integer')]
    private int $value;

    public function __construct(float $value)
    {
        Assert::range($value, 0.1, 1);
        $this->value = $value * 100;
    }
    
    public function value(): float
    {
        return $this->value / 100;
    }
}
