<?php

namespace App\ContentManagement\Ui\Static\Web\Controller;

use App\ContentManagement\Application\Static\Query\FindSitemap;
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

        return $this->render('web/content_management/static/sitemap.html.twig', [
            'sitemap' => $sitemap
        ]);
    }
}
