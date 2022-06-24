<?php

namespace App\ContentManagement\Infrastructure\Website\Repository\Doctrine;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class PageRepository extends ServiceEntityRepository implements PageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function add(Page $page): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($page);
        $manager->flush();
    }

    public function findById(PageId $id): ?Page
    {
        return $this->find($id->toString());
    }

    public function findByPath(string $path): ?Page
    {
        return $this->findOneBy([
            'route.path' => $path
        ]);
    }

    public function findLocaleAlternates(PageId $id): array
    {
        $currentPage = $this->find($id);

        return $this
            ->createQueryBuilder('page')
            ->select('page')
            ->where('page.route.name = :routeName')
            ->setParameter('routeName', $currentPage->routeName())
            ->getQuery()
            ->getResult();
    }

    public function findActives(): array
    {
        return $this->findAll();
    }

    public function findIndexables(): array
    {
        return $this->findBy([
            'seo.shouldIndex' => true
        ]);
    }

    public function nextIdentity(): PageId
    {
        return PageId::fromString(Uuid::v4());
    }
}
