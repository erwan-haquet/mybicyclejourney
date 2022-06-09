<?php

namespace App\ContentManagement\Ui\Website\Web\Dto;

use App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs\Breadcrumbs;
use Library\Utils\View;

/**
 * All the necessary data to render the meta tags.
 */
class Metadata extends View
{
    /**
     * Page title
     */
    public string $title;

    /**
     * Page meta description
     */
    public string $description;

    /**
     * If set to true, the "nofollow" tag will be added.
     *
     * @see https://clutch.co/seo-firms/resources/meta-tags-that-improve-seo#Robots
     */
    public bool $noindex = false;

    /**
     * If set to true, the "nofollow" tag will be added.
     *
     * @see https://clutch.co/seo-firms/resources/meta-tags-that-improve-seo#Robots
     */
    public bool $nofollow = false;

    /**
     * Other available locales for current page.
     *
     * @var LocaleAlternate[]
     */
    public array $localeAlternates = [];

    /**
     * Open graph meta.
     *
     * <meta property="og:x" content="x">
     */
    public OpenGraph $openGraph;

    public Breadcrumbs $breadcrumbs;
}
