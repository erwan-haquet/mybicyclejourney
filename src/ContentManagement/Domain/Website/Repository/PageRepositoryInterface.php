<?php

namespace App\ContentManagement\Domain\Website\Repository;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\PageId;

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
     * Generates a new id.
     */
    public function nextIdentity(): PageId;
}
