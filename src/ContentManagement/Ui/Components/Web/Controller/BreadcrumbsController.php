<?php

namespace App\ContentManagement\Ui\Components\Web\Controller;

use App\ContentManagement\Application\Components\Query\BuildBreadcrumbs;
use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use Library\CQRS\Query\QueryBus;
use Psr\Log\LoggerInterface;
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
        Request         $request,
        LoggerInterface $logger,
        QueryBus        $queryBus
    ): Response
    {
        if (!$path = $request->query->get('path')) {
            return new Response('Missing path', Response::HTTP_BAD_REQUEST);
        }
        
        $query = new BuildBreadcrumbs(['path' => urldecode($path)]);

        try {
            $breadcrumbs = $queryBus->query($query);
        } catch (PageNotFoundException) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->render('web/shared/components/_breadcrumbs.html.twig', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
