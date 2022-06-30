<?php

namespace App\ContentManagement\Domain\Seo\Model;

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
     * The canonical url of the page.
     */
    public ?string $canonicalUrl = null;

    /**
     * Open graph meta.
     *
     * <meta property="og:x" content="x">
     */
    public ?OpenGraph $openGraph = null;

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
}
