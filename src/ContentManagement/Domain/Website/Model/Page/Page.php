<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Meta;
use App\ContentManagement\Domain\Website\Model\Page\Meta\Collection as MetaCollection;
use App\ContentManagement\Domain\Website\Model\Page\Seo\Seo;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brings together all the resources required to render a web page.
 */
#[ORM\Entity]
#[ORM\Table(name: "content_management_website_page")]
class Page
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(type: 'string', enumType: Type::class)]
    private Type $type;

    #[ORM\Embedded(class: Title::class)]
    private Title $title;

    #[ORM\Embedded(class: Path::class)]
    private Path $path;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: "children")]
    private ?Page $parent;

    #[ORM\OneToMany(mappedBy: "parent", targetEntity: Page::class)]
    private Collection $children;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    #[ORM\Embedded(class: Seo::class)]
    private Seo $seo;

    #[ORM\OneToMany(mappedBy: "page", targetEntity: Meta::class, cascade: ["all"])]
    private Collection $metas;

    public function __construct(
        PageId         $id,
        Title          $title,
        Type           $type,
        Path           $path,
        ?Page          $parent,
        Seo            $seo,
        MetaCollection $metas
    )
    {
        $this->id = $id->toString();

        $this->title = $title;
        $this->type = $type;
        $this->path = $path;
        $this->parent = $parent;

        $this->seo = $seo;

        $this->metas = new ArrayCollection($metas->toArray());

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): PageId
    {
        return PageId::fromString($this->id);
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function path(): Path
    {
        return $this->path;
    }

    public function type(): Type
    {
        return $this->type;
    }

    public function parent(): ?Page
    {
        return $this->parent;
    }

    public function children(): iterable
    {
        return $this->children;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updateAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function seo(): Seo
    {
        return $this->seo;
    }

    public function metas(): array
    {
        return $this->metas->toArray();
    }
}
