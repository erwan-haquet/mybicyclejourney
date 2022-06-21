<?php

namespace App\AccountManagement\Infrastructure\User\Repository\Doctrine;

use App\AccountManagement\Domain\User\Exception\EmailIsAlreadyRegistered;
use App\AccountManagement\Domain\User\Exception\UsernameIsAlreadyRegistered;
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
        if ($this->findByEmail($user->email())) {
            throw new EmailIsAlreadyRegistered();
        }

        if ($this->findByUsername($user->username())) {
            throw new UsernameIsAlreadyRegistered();
        }

        $manager = $this->getEntityManager();
        $manager->persist($user);
        $manager->flush();
    }

    public function update(User $user): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($user);
        $manager->flush();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByUsername(string $username): ?User
    {
        return $this
            ->createQueryBuilder('user')
            ->select('user')
            ->where('LOWER(user.username) = :username')
            ->setParameter('username', strtolower($username))
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function nextIdentity(): UserId
    {
        return UserId::fromString(Uuid::v4());
    }

    public function findById(UserId $id): ?User
    {
        return $this->find($id);
    }
}
