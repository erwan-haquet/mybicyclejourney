<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

/**
 * The type / root category of the page.
 */
enum Type: string
{
    case Static = 'static';

    /**
     * Pages relative to the user security management, eg: signup, login, sign-out...
     */
    case Security = 'security';
}
