<?php

namespace App\ContentManagement\Ui\Components\Web\Dto\Metadata;

use Library\Utils\View;

class OpenGraphDto extends View
{
    public ?string $title;
    
    public ?string $description;

    public ?string $image;

    public ?string $locale;

    /**
     * Other available locales for current page.
     *
     * @var LocaleAlternateDto[]
     */
    public array $localeAlternates = [];

    /**
     * The canonical url of the page.
     */
    public string $url;
}
