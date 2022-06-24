<?php

namespace App\ContentManagement\Ui\Website\Web\Dto\Metadata;

use Library\Utils\View;

class OpenGraphDto extends View
{
    public ?string $title;

    public ?string $description;

    public ?string $image;

    /**
     * The canonical url of the page.
     */
    public string $canonicalUrl;
    
    /**
     * Other available locales for current page.
     *
     * @var LocaleAlternateDto[]
     */
    public array $localeAlternates = [];
}
