<?php

namespace Tests\Fixtures\App\AccountManagement\Domain\User\Model;

use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;
use App\Supporting\Domain\I18n\Model\Locale;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public static function new(
        ?UserId $id = null,
        ?string $email = null,
        ?Locale $locale = null,
    ): User
    {
        $user = new User(
            id: $id ?? UserId::fromString(Uuid::v4()),
            email: $email ?? 'test@mybicyclejourney.com',
            locale: $locale ?? Locale::from('EN')
        );
        $user->setPassword($encodedPassword ?? 'anEncodedPassword');

        return $user;
    }
}
