<?php

namespace Tests\Fixtures\App\AccountManagement\Application\User\Command;

use App\AccountManagement\Application\User\Command\Signup;
use App\AccountManagement\Domain\User\Model\UserId;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\Uid\Uuid;

class SignupFactory
{
    public static function new(
        ?UserId $id = null,
        ?Locale $locale = null,
        ?string $email = null,
        ?string $plainPassword = null,
    ): Signup
    {
        return new Signup([
            'id' => $id ?? UserId::fromString(Uuid::v4()),
            'locale' => $locale ?? Locale::from('EN'),
            'email' => $email ?? 'erwan@mybicyclejourney.com',
            'plainPassword' => $plainPassword ??'teI0Hh*ls09t+I@'
        ]);
    }
}
