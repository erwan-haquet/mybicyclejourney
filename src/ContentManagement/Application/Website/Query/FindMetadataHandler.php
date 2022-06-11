<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Exception\PageNotFound;
use App\ContentManagement\Domain\Website\Factory\MetadataFactory;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata\Metadata;
use Library\CQRS\Query\QueryHandlerInterface;

class FindMetadataHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;
    private MetadataFactory $metadataFactory;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        MetadataFactory         $metadataFactory
    )
    {
        $this->pageRepository = $pageRepository;
        $this->metadataFactory = $metadataFactory;
    }

    /**
     * @throws PageNotFound
     */
    public function __invoke(FindMetadata $query): Metadata
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            throw PageNotFound::forPath($query->path);
        }

        return $this->metadataFactory->create($page);
    }
}
