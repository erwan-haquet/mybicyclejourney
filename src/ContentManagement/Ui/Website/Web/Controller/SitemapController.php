<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Sitemap\Sitemap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __invoke(PageRepositoryInterface $pageRepository): Response
    {
        $pages = $pageRepository->findAll();
        
        return $this->render('web/sitemap.html.twig', [
            'sitemap' => Sitemap::new($pages)
        ]);
    }
}
