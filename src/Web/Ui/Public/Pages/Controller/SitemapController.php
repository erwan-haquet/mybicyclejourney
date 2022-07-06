<?php

namespace App\Web\Ui\Public\Pages\Controller;

use App\Web\Application\Public\Query\Pages\BuildSitemap;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __invoke(QueryBus $queryBus): Response
    {
        $query = new BuildSitemap();
        $sitemap = $queryBus->query($query);

        return $this->render('web/public/pages/sitemap/index.html.twig', [
            'sitemap' => $sitemap
        ]);
    }
}
