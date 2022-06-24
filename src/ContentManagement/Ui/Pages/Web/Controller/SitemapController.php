<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Pages\Web\Dto\Sitemap\SitemapDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
class SitemapController extends AbstractController
{
    public function __invoke(PageRepositoryInterface $pageRepository): Response
    {
        $pages = $pageRepository->findAll();
        
        return $this->render('web/pages/sitemap.html.twig', [
            'sitemap' => SitemapDto::new($pages)
        ]);
    }
}
