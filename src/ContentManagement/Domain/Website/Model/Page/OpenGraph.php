<?php

namespace App\ContentManagement\Domain\Website\Model\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * The Open Graph protocol enables any web page to become a rich object
 * in a social graph. For instance, this is used on Facebook to allow any
 * web page to have the same functionality as any other object on Facebook.
 *
 * @see https://ogp.me/
 */
#[ORM\Embeddable]
class OpenGraph
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image;

    public function __construct(
        string $title = null,
        string $description = null,
        string $image = null,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
    }

    /**
     * The title of your object as it should appear within the graph, e.g., "The Rock".
     */
    public function title(): ?string
    {
        return $this->title;
    }

    /**
     * A one to two sentence description of your object.
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * An image URL which should represent your object within the graph.
     */
    public function image(): ?string
    {
        return $this->image;
    }
}
