<?php

namespace App\ContentManagement\Ui\Website\Web\Dto;

use Library\Utils\View;

/**
 * All the necessary data to render the meta tags.
 */
class Metadata extends View
{
    public string $description;

    public string $title;

    /**
     * If set to true, the "noindex, nofollow" tag will be added.
     * Be carefully, it means that crawlers won't index the page !
     */
    public bool $noIndexNoFollow;

    /**
     * Other available locales for current page.
     * @var LocaleAlternate[]
     */
    public array $localeAlternates = [];

    public OpenGraph $openGraph;
}
