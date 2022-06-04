<?php

namespace App\ContentManagement\Domain\Website\Factory;

use App\ContentManagement\Domain\Website\Model\Page\Meta;
use App\ContentManagement\Domain\Website\Model\Page\Meta\MetaInterface;
use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Model\Page\Path;
use App\ContentManagement\Domain\Website\Model\Page\Title;
use Library\Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PageFactory
{
    protected Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Creates a new page with default configuration properties.
     */
    public function create(Title $title, Path $path, array $metas): Page
    {
        Assert::allIsInstanceOf($metas, MetaInterface::class);

        return new Page(
            title: $title,
            path: $path,
            metas: new Meta\Collection([
                Meta\OpenGraph\Locale::new('fr_fr'),
                Meta\OpenGraph\Type::new('website'),
                Meta\OpenGraph\Url::new($this->request->getUri()),
                Meta\OpenGraph\SiteName::new('My Bicycle Journey '),
                Meta\Name\Viewport::new('width=device-width, initial-scale=1, shrink-to-fit=no'),
            ])
        );
    }
}
