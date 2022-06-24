<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use App\ContentManagement\Application\Website\Query\FindMetadata;
use App\ContentManagement\Domain\Website\Exception\PageNotFoundException;
use Library\CQRS\Query\QueryBus;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * This controller does not expose any route, it is for internal use only.
 */
class MetadataController extends AbstractController
{
    /**
     * This controller render page metadata based on the given urlencoded path.
     */
    public function __invoke(
        string          $encodedPath,
        LoggerInterface $logger,
        Request $request,
        QueryBus        $queryBus
    ): Response
    {
        $query = new FindMetadata([
            'path' => urldecode($encodedPath)
        ]);

        try {
            $metadata = $queryBus->query($query);
        } catch (PageNotFoundException $exception) {
            $logger->error(sprintf(
                'Tried to render metadata for path "%s", but the Page does not exists.',
                $query->path
            ), ['exception' => $exception]);

            return new Response('', Response::HTTP_NO_CONTENT);
        }
        
        return $this->render('web/shared/_metadata.html.twig', [
            'metadata' => $metadata
        ]);
    }


}
