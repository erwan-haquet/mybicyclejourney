<?php

namespace App\ContentManagement\Ui\Frontend\Pages\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Frontend\Pages\View\Sitemap\Sitemap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitemap.xml', name: 'frontend_sitemap', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __invoke(PageRepositoryInterface $pageRepository): Response
    {
        $pages = $pageRepository->findIndexables();

        return $this->render('frontend/pages/sitemap/index.html.twig', [
            'sitemap' => Sitemap::new($pages)
        ]);
    }
}
