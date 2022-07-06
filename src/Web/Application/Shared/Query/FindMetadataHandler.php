<?php

namespace App\Web\Application\Shared\Query;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Web\Ui\Shared\Assembler\MetadataAssembler;
use App\Web\Ui\Shared\Dto\Metadata\Metadata;
use Library\CQRS\Query\QueryHandlerInterface;
use Psr\Log\LoggerInterface;

class FindMetadataHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;
    private MetadataAssembler $metadataFactory;
    private LoggerInterface $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        MetadataAssembler       $metadataFactory,
        LoggerInterface         $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->metadataFactory = $metadataFactory;
        $this->logger = $logger;
    }

    public function __invoke(FindMetadata $query): Metadata
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            $this->logger->error(sprintf(
                'Tried to render metadata for path "%s", but the Page does not exists.',
                $query->path
            ));

            return $this->metadataFactory->build404error();
        }

        return $this->metadataFactory->buildFromPage($page);
    }
}
