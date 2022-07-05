<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Application\Seo\Query\FindSitemap;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __invoke(QueryBus $queryBus): Response
    {
        $query = new FindSitemap();
        $sitemap = $queryBus->query($query);

        return $this->render('web/pages/sitemap/index.html.twig', [
            'sitemap' => $sitemap
        ]);
    }
}
