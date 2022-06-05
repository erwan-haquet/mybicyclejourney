<?php

namespace App\Supporting\Domain\I18n\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * A locale context for I18.
 */
#[ORM\Embeddable]
class Locale
{
    /**
     * Language in ISO 639-1 format.
     * eg: 'fr', 'en'...
     * @see https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
     */
    #[ORM\Column(type: 'string')]
    private string $language;

    /**
     * Country in ISO 639-1 format.
     * eg: 'FR', 'EN'...
     * @see https://en.wikipedia.org/wiki/ISO_3166-1#Current_codes
     */
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $country;

    public function __construct(string $language, string $country = null)
    {
        $this->language = $language;
        $this->country = $country;
    }

    /**
     * Creates a new object from a locale string.
     */
    public static function new(string $locale): Locale
    {
        $pieces = explode("_", $locale);
        
        // Locale does not contain county code
        if (count($pieces) === 1) {
            return new self($pieces[0]);
        }
        
        return new self($pieces[0], $pieces[1]);
    }
    
    public static function fromString(string $language, string $country): Locale
    {
        return new self($language, $country);
    }

    public function __toString(): string
    {
        return sprintf('%s_%s', $this->language, $this->country);
    }
}
