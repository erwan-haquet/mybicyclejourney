<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use App\ContentManagement\Domain\Website\Factory\MetadataFactory;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata\MetadataDto;
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
     * @throws PageNotFoundException
     */
    public function __invoke(FindMetadata $query): MetadataDto
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            throw PageNotFoundException::forPath($query->path);
        }

        return $this->metadataFactory->create($page);
    }
}
