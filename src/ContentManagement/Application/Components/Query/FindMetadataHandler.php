<?php

namespace App\ContentManagement\Application\Components\Query;

use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Components\Web\Assembler\MetadataAssembler;
use App\ContentManagement\Ui\Components\Web\Dto\Metadata\MetadataDto;
use Library\CQRS\Query\QueryHandlerInterface;

class FindMetadataHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;
    private MetadataAssembler $metadataAssembler;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        MetadataAssembler       $metadataAssembler
    )
    {
        $this->pageRepository = $pageRepository;
        $this->metadataAssembler = $metadataAssembler;
    }

    /**
     * @throws PageNotFoundException
     */
    public function __invoke(FindMetadata $query): MetadataDto
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            throw PageNotFoundException::forPath($query->path);
        }

        return $this->metadataAssembler->create($page);
    }
}
