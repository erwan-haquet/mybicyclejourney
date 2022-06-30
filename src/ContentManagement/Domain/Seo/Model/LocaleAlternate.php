<?php

namespace App\ContentManagement\Domain\Seo\Model;

use Library\Utils\View;

class LocaleAlternate extends View
{
    public string $locale;
    
    public string $url;
}
