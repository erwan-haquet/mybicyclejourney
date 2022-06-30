<?php

namespace App\ContentManagement\Ui\Components\Web\Controller;

use App\ContentManagement\Application\Components\Query\FindBreadcrumbs;
use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use Library\CQRS\Query\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/components/breadcrumbs', 
    name: 'components_breadcrumbs',
    requirements: ['_locale' => 'en']
)]
class BreadcrumbsController extends AbstractController
{
    /**
     * Render the breadcrumbs based on the given urlencoded path.
     */
    public function __invoke(
        Request         $request,
        LoggerInterface $logger,
        QueryBus        $queryBus
    ): Response
    {
        $path = $request->query->get('path');

        $query = new FindBreadcrumbs([
            'path' => urldecode($path)
        ]);

        try {
            $breadcrumbs = $queryBus->query($query);
        } catch (PageNotFoundException $exception) {
            $logger->error(sprintf(
                'Tried to render breadcrumbs for path "%s", but the Page does not exists.',
                $query->path
            ), ['exception' => $exception]);

            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->render('web/shared/components/_breadcrumbs.html.twig', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
