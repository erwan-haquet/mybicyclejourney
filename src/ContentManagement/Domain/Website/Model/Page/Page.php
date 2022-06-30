<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use App\Supporting\Domain\I18n\Model\Locale;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brings together all the resources necessary to render a web page.
 * Metadata / Breadcrumbs ...
 *
 * This model is designed for content management administration
 * therefor it should not include technical meanings.
 */
#[ORM\Entity]
#[ORM\Table(name: "content_management_website_page")]
class Page
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $label;

    #[ORM\Column(type: 'string')]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $imageUrl;

    #[ORM\Embedded(class: Locale::class)]
    private Locale $locale;

    #[ORM\Embedded(class: Route::class)]
    private Route $route;

    #[ORM\Embedded(class: Crawl::class)]
    private Crawl $crawl;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: "children")]
    private ?Page $parent;

    /** @var Collection<Page> */
    #[ORM\OneToMany(mappedBy: "parent", targetEntity: Page::class)]
    private Collection $children;

    public function __construct(
        PageId  $id,
        Route   $route,
        string  $title,
        string  $description,
        string  $label,
        ?string $imageUrl,
        Locale  $locale,
        ?Page   $parent,
        ?Crawl  $crawl,
    )
    {
        $this->id = $id->toString();
        $this->title = $title;
        $this->description = $description;
        $this->label = $label;
        $this->imageUrl = $imageUrl;

        $this->locale = $locale;
        $this->route = $route;
        $this->parent = $parent;

        $this->crawl = $crawl ?? Crawl::default();
    }

    public function id(): PageId
    {
        return PageId::fromString($this->id);
    }

    /**
     * Title of the page, display in browser tabs.
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Meta description, not visible for user but used by
     * crawlers to understand the page activity.
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * A short label to display in breadcrumbs.
     */
    public function label(): string
    {
        return $this->label;
    }

    public function locale(): Locale
    {
        return $this->locale;
    }

    public function parent(): ?Page
    {
        return $this->parent;
    }

    public function children(): iterable
    {
        return $this->children;
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

    public function shouldIndex(): bool
    {
        return $this->crawl->shouldIndex();
    }

    public function crawlPriority(): float
    {
        return $this->crawl->priority();
    }

    public function language(): string
    {
        return $this->locale->language();
    }

    /**
     * An image URL which should represent your object within the graph.
     * Format MUST be at least 1200 x 630, and respect the ratio.
     */
    public function imageUrl(): ?string
    {
        return $this->imageUrl;
    }
}
