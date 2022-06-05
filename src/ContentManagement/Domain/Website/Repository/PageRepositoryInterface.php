<?php

namespace App\ContentManagement\Domain\Website\Repository;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Model\Page\Path;

interface PageRepositoryInterface
{
    /**
     * Adds a new page to the repository.
     */
    public function add(Page $page): void;

    /**
     * Finds a page by its id.
     */
    public function findById(PageId $id): ?Page;

    /**
     * Finds a page by its relative path.
     */
    public function findByPath(Path $path): ?Page;

    /**
     * Generates a new id.
     */
    public function nextIdentity(): PageId;
}
