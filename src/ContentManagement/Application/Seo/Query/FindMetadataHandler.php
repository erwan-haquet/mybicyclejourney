<?php

namespace App\ContentManagement\Application\Seo\Query;

use App\ContentManagement\Domain\Seo\Factory\MetadataFactory;
use App\ContentManagement\Domain\Seo\Model\Metadata;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use Library\CQRS\Query\QueryHandlerInterface;
use Psr\Log\LoggerInterface;

class FindMetadataHandler implements QueryHandlerInterface
{
    private PageRepositoryInterface $pageRepository;
    private MetadataFactory $factory;
    private LoggerInterface $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        MetadataFactory         $factory,
        LoggerInterface         $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->factory = $factory;
        $this->logger = $logger;
    }

    public function __invoke(FindMetadata $query): Metadata
    {
        if (!$page = $this->pageRepository->findByPath($query->path)) {
            $this->logger->error(sprintf(
                'Tried to render metadata for path "%s", but the Page does not exists.',
                $query->path
            ));

            return $this->factory->build404error();
        }

        return $this->factory->buildFromPage($page);
    }
}
