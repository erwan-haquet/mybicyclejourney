<?php

namespace App\ContentManagement\Domain\Website\Model\Page\Meta;

use App\ContentManagement\Domain\Website\Model\Page\Meta\Name;
use App\ContentManagement\Domain\Website\Model\Page\Meta\OpenGraph;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "content_management_website_page_meta")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "meta" => Meta::class,
    "name_application_name" => Name\ApplicationName::class,
    "name_author" => Name\Author::class,
    "name_description" => Name\Description::class,
    "name_generator" => Name\Generator::class,
    "name_keywords" => Name\Keywords::class,
    "name_referrer" => Name\Referrer::class,
    "name_robots" => Name\Robots::class,
    "name_viewport" => Name\Viewport::class,
    "og_description" => OpenGraph\Description::class,
    "og_image" => OpenGraph\Image::class,
    "og_locale" => OpenGraph\Locale::class,
    "og_site_name" => OpenGraph\SiteName::class,
    "og_title" => OpenGraph\Title::class,
    "og_type" => OpenGraph\Type::class,
    "og_url" => OpenGraph\Url::class,
])]
abstract class Meta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected ?int $id;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: "metas")]
    protected ?Page $page;

    /**
     * A unique identifier used as discriminator.
     */
    public abstract function getType(): string;

    /**
     * Render the tag to display in html <head>.
     *
     * eg: '<meta name="description" content="A super cool website for bikers">'
     */
    public abstract function render(): string;
}
