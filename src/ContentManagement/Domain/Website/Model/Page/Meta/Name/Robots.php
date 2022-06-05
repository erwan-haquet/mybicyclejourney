<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use Library\Assert\Assert;
use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * The behavior that cooperative crawlers, or "robots", should use with the page.
 * It is a comma-separated list of the values below.
 */
#[ORM\Entity]
class Robots extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;

    public function __construct(array $values)
    {
        Assert::allIsAnyOf($values, self::availableValues());

        $this->content = implode(', ', $values);
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="robots" content="%s">',
            $this->content
        );
    }
    
    private static function availableValues(): array
    {
        return [
            // Allows the robot to index the page (default).
            // Used by: All
            'index',

            // Requests the robot to not index the page.
            // Used by: All
            'noindex',

            // Allows the robot to follow the links on the page (default).
            // Used by: All
            'follow',

            // Requests the robot to not follow the links on the page.
            // Used by: All
            'nofollow',

            // Equivalent to index, follow
            // Used by: Google
            'all',

            // Equivalent to noindex, nofollow
            // Used by: Google
            'none',

            // Requests the search engine not to cache the page content.
            // Used by: Google, Yahoo, Bing
            'noarchive',

            // Prevents displaying any description of the page in search engine results.
            // Used by: Google, Bing
            'nosnippet',

            // Requests this page not to appear as the referring page of an indexed image.
            // Used by: Google
            'noimageindex',

            // Synonym of noarchive.
            // Used by: Bing
            'nocache',
        ];
    }

    public function getType(): string
    {
        return 'name_robots';
    }
}
