<?php

namespace App\ContentManagement\Infrastructure\Website\Repository\Doctrine;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Marketing\Domain\Launch\Model\EarlyBird;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EarlyBird::class);
    }

    public function add(Page $page): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($page);
        $manager->flush();
    }

    public function findById(PageId $id): ?Page
    {
        return $this->find($id);
    }

    public function nextIdentity(): PageId
    {
        return PageId::fromString(Uuid::v4());
    }
}
