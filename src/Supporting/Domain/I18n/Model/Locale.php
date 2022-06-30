<?php

namespace App\Supporting\Domain\I18n\Model;

use Doctrine\ORM\Mapping as ORM;
use Library\Assert\Assert;

/**
 * The user locale for translation / internationalization.
 *
 * In this application, we are using only the language to localize.
 * This means that country code is dropped.
 */
#[ORM\Embeddable]
class Locale
{
    #[ORM\Column(type: 'string')]
    private string $language;

    public function __construct(string $language)
    {
        // Assert that language respect ISO 639-1 format.
        Assert::length($language, 2);

        $this->language = strtolower($language);
    }

    /**
     * Creates a new object from a locale string.
     */
    public static function from(string $locale): Locale
    {
        // If locale includes country we remove it.
        $pieces = explode("_", $locale);

        return new self($pieces[0]);
    }

    /**
     * Language in ISO 639-1 format.
     * eg: 'fr', 'en'...
     * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    public function language(): string
    {
        return $this->language;
    }

    public function __toString(): string
    {
        return $this->language;
    }
}
