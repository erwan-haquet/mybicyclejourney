<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta\Name;

use Library\Assert\Assert;

/**
 * Controls the HTTP Referer header of requests sent from the document.
 */
class Referrer extends MetaName
{
    public const NAME = 'referrer';

    public static function new(string $content): Referrer
    {
        Assert::oneOf($content, self::availableValues());

        return new self(self::NAME, $content);
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
}
