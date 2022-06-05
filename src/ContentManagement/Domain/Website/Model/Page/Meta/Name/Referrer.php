<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use Library\Assert\Assert;
use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use Doctrine\ORM\Mapping as ORM;

/**
 * Controls the HTTP Referer header of requests sent from the document.
 */
#[ORM\Entity]
class Referrer extends Meta
{
    #[ORM\Column(name: "value", type: "string")]
    private string $content;
    
    public function __construct(string $content)
    {
        Assert::oneOf($content, self::availableValues());

        $this->content = $content;
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="referrer" content="%s">',
            $this->content
        );
    }
    
    private static function availableValues(): array
    {
        return [
            // Do not send a HTTP Referer header.
            'no-referrer',

            // Send the origin of the document.
            'origin',

            // Send the full URL when the destination is at least as secure as the current page (HTTP(S)→HTTPS),
            // but send no referrer when it's less secure (HTTPS→HTTP). This is the default behavior.
            'no-referrer-when-downgrade',

            // Send the full URL (stripped of parameters) for same-origin requests,
            // but only send the origin for other cases.
            'origin-when-cross-origin',

            // Send the full URL (stripped of parameters) for same-origin requests.
            // Cross-origin requests will contain no referrer header.
            'same-origin',

            // Send the origin when the destination is at least as secure as the current page (HTTP(S)→HTTPS),
            // but send no referrer when it's less secure (HTTPS→HTTP).
            'strict-origin',

            // Send the full URL (stripped of parameters) for same-origin requests.
            // Send the origin when the destination is at least as secure as the current page (HTTP(S)→HTTPS).
            // Otherwise, send no referrer.
            'strict-origin-when-cross-origin',

            // Send the full URL (stripped of parameters) for same-origin or cross-origin requests.
            'unsafe-URL',
        ];
    }

    public function getType(): string
    {
        return 'name_referer';
    }
}
