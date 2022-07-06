<?php

namespace App\Web\Ui\Shared\Controller;

use App\Web\Application\Shared\Query\FindMetadata;
use Library\CQRS\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/_seo/metadata',
    name: 'seo_metadata',
    requirements: ['_locale' => 'en']
)]
class MetadataController extends AbstractController
{
    /**
     * This controller render page metadata based on the given path.
     */
    public function __invoke(Request $request, QueryBus $queryBus): Response
    {
        if (!$path = $request->query->get('path')) {
            return new Response('Missing path', Response::HTTP_BAD_REQUEST);
        }

        $query = new FindMetadata(['path' => urldecode($path)]);
        $metadata = $queryBus->query($query);

        return $this->render('web/shared/seo/_metadata.html.twig', [
            'metadata' => $metadata
        ]);
    }
}
