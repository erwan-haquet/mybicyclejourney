<?php

namespace App\Web\Ui\Shared\Dto\Metadata;

use Library\Utils\View;

class OpenGraph extends View
{
    public ?string $title;
    
    public ?string $description;

    public ?string $image;

    public ?string $locale;

    /**
     * Other available locales for current page.
     *
     * @var LocaleAlternate[]
     */
    public array $localeAlternates = [];

    /**
     * The canonical url of the page.
     */
    public string $url;
}
