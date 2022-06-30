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

    #[ORM\Embedded(class: Locale::class)]
    private Locale $locale;

    #[ORM\Embedded(class: Route::class)]
    private Route $route;

    #[ORM\Embedded(class: Seo::class)]
    private Seo $seo;

    #[ORM\Embedded(class: OpenGraph::class, columnPrefix: "social_open_graph_")]
    private OpenGraph $openGraph;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: "children")]
    private ?Page $parent;

    /** @var Collection<Page> */
    #[ORM\OneToMany(mappedBy: "parent", targetEntity: Page::class)]
    private Collection $children;

    public function __construct(
        PageId     $id,
        string     $title,
        string     $description,
        string     $label,
        Locale     $locale,
        Route      $route,
        ?Page      $parent,
        ?Seo       $seo,
        ?OpenGraph $openGraph,
    ) {
        $this->id = $id->toString();
        $this->title = $title;
        $this->description = $description;
        $this->label = $label;

        $this->locale = $locale;
        $this->route = $route;
        $this->parent = $parent;

        $this->seo = $seo ?? new Seo();
        $this->openGraph = $openGraph ?? new OpenGraph(
                title: $title,
                description: $description,
            );
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
        return $this->seo->shouldIndex();
    }

    public function crawlPriority(): float
    {
        return $this->seo->crawlPriority();
    }

    public function language(): string
    {
        return $this->locale->language();
    }

    public function openGraph(): OpenGraph
    {
        return $this->openGraph;
    }
}
