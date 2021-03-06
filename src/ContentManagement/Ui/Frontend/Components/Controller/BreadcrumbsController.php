<?php

namespace App\ContentManagement\Ui\Frontend\Components\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Frontend\Components\View\Breadcrumbs\Breadcrumbs;
use Library\CQRS\Query\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/_components/breadcrumbs',
    name: 'frontend_components_breadcrumbs',
    requirements: ['_locale' => 'en']
)]
class BreadcrumbsController extends AbstractController
{
    /**
     * Builds the breadcrumbs for given page path.
     */
    public function __invoke(
        Request                 $request,
        PageRepositoryInterface $pageRepository,
        LoggerInterface         $logger,
        QueryBus                $queryBus
    ): Response {
        if (!$path = $request->query->get('path')) {
            return new Response('Missing path', Response::HTTP_BAD_REQUEST);
        }

        if (!$page = $pageRepository->findByPath($path)) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->render('frontend/components/breadcrumbs/index.html.twig', [
            'breadcrumbs' => Breadcrumbs::new($page)
        ]);
    }
}
