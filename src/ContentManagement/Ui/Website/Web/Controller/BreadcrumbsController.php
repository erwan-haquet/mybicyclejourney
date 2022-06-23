<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use App\ContentManagement\Application\Website\Query\FindBreadcrumbs;
use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use Library\CQRS\Query\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * This controller does not expose any route, it is for internal use only.
 */
class BreadcrumbsController extends AbstractController
{
    /**
     * Render the breadcrumbs based on the given urlencoded path.
     */
    public function __invoke(
        string          $encodedPath,
        LoggerInterface $logger,
        QueryBus        $queryBus
    ): Response
    {
        $query = new FindBreadcrumbs([
            'path' => urldecode($encodedPath)
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

        return $this->render('web/shared/_breadcrumbs.html.twig', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
