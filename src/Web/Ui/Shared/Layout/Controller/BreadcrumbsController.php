<?php

namespace App\Web\Ui\Shared\Layout\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Web\Ui\Shared\Layout\Dto\Breadcrumbs\Breadcrumbs;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/_components/breadcrumbs',
    name: 'components_breadcrumbs',
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
        QueryBus                $queryBus
    ): Response {
        if (!$path = $request->query->get('path')) {
            return new Response('Missing path', Response::HTTP_BAD_REQUEST);
        }

        if (!$page = $pageRepository->findByPath($path)) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->render('web/shared/layout/breadcrumbs/index.html.twig', [
            'breadcrumbs' => Breadcrumbs::new($page)
        ]);
    }
}
