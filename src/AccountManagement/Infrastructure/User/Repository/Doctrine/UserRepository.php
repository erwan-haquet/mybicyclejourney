<?php

namespace App\AccountManagement\Infrastructure\User\Repository\Doctrine;

use App\AccountManagement\Domain\User\Exception\UsernameIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function register(User $user): void
    {
        if ($this->findBy(['email' => $user->email()])) {
            throw new EmailIsAlreadyRegistered();
        }

        if ($this->findBy(['username' => $user->username()])) {
            throw new UsernameIsAlreadyRegistered();
        }

        $manager = $this->getEntityManager();
        $manager->persist($user);
        $manager->flush();
    }

    public function nextIdentity(): UserId
    {
        return UserId::fromString(Uuid::v4());
    }
}
