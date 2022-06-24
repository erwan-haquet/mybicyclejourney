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
     * Finds a page by its relative path.
     */
    public function findByPath(string $path): ?Page;
    
    /**
     * Finds all active / published pages.
     * 
     * @return Page[]
     */
    public function findActives(): array;
    
    /**
     * Finds all indexable pages.
     * 
     * @return Page[]
     */
    public function findIndexables(): array;
    
    /**
     * Finds locale alternatives for the given page, including the given page.
     * 
     * @return Page[]
     */
    public function findLocaleAlternates(PageId $id): array;

    /**
     * Generates a new id.
     */
    public function nextIdentity(): PageId;
}
