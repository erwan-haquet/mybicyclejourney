<?php

namespace App\Marketing\Infrastructure\Launch\Repository\Doctrine;

use App\Marketing\Domain\Launch\Model\EarlyBird;
use App\Marketing\Domain\Launch\Repository\EarlyBirdRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EarlyBirdRepository extends ServiceEntityRepository implements EarlyBirdRepositoryInterface
{
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EarlyBird::class);
    }

    public function add(EarlyBird $earlyBird)
    {
        $manager = $this->getEntityManager();

        $manager->persist($earlyBird);
        $manager->flush();
    }
}
