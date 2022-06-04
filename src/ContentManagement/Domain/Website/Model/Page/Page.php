<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Seo\Seo;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

/**
 * Brings together all the resources required for rendering a web page.
 */
class Page
{
    private PageId $id;

    private Title $title;

    private Path $path;

    private Type $type;

    private ?Page $parent;

    private Collection $children;

    private DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

    private Seo $seo;
    
    private Meta\Collection $metas;

    public function __construct(
        Title $title,
        Path  $path,
        Meta\Collection $metas = null
    )
    {
        $this->title = $title;
        $this->path = $path;
        $this->metas = $metas ?? new Meta\Collection();
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function path(): Path
    {
        return $this->path;
    }
    
    public function metas(): Meta\Collection
    {
        return $this->metas;
    }
}
