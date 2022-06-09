<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use App\Supporting\Domain\I18n\Model\Locale;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brings together all the resources required to render a web page.
 * 
 * This model is designed for content management administration and
 * should not include too many technical logics. 
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

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Embedded(class: Locale::class)]
    private Locale $locale;

    #[ORM\Embedded(class: Route::class)]
    private Route $route;

    #[ORM\Embedded(class: Seo::class)]
    private Seo $seo;

    #[ORM\Embedded(class: Social::class)]
    private Social $social;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: "children")]
    private ?Page $parent;

    #[ORM\OneToMany(mappedBy: "parent", targetEntity: Page::class)]
    private Collection $children;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct(
        PageId $id,
        string $title,
        string $description,
        Locale $locale,
        Type   $type,
        Route  $route,
        ?Page  $parent,
        Seo    $seo,
        Social $social,
    )
    {
        $this->id = $id->toString();
        $this->title = $title;
        $this->description = $description;

        $this->locale = $locale;
        $this->type = $type;
        $this->route = $route;
        $this->parent = $parent;
        
        $this->seo = $seo;
        $this->social = $social;

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): PageId
    {
        return PageId::fromString($this->id);
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function path(): string
    {
        return $this->route->path();
    }

    public function url(): string
    {
        return $this->route->url();
    }
    
    public function routeName(): string
    {
        return $this->route->name();
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
    
    public function social(): Social
    {
        return $this->social;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }
    
    public function language(): string
    {
        return $this->locale->language();
    }
}
