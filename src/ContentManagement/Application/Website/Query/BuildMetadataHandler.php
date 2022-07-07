<?php

namespace App\ContentManagement\Application\Website\Query;

use App\ContentManagement\Domain\Website\Factory\MetadataFactory;
use App\ContentManagement\Domain\Website\Model\Metadata\Metadata;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use Library\CQRS\Query\QueryHandlerInterface;
use Psr\Log\LoggerInterface;

class BuildMetadataHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;
    private MetadataFactory $metadataFactory;
    private LoggerInterface $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        MetadataFactory         $metadataFactory,
        LoggerInterface         $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->metadataFactory = $metadataFactory;
        $this->logger = $logger;
    }

    public function __invoke(BuildMetadata $query): Metadata
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
