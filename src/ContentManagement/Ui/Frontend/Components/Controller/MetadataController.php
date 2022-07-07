<?php

namespace App\ContentManagement\Ui\Frontend\Components\Controller;

use App\ContentManagement\Application\Website\Query\BuildMetadata;
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

        $query = new BuildMetadata(['path' => urldecode($path)]);
        $metadata = $queryBus->query($query);

        return $this->render('frontend/components/metadata/index.html.twig', [
            'metadata' => $metadata
        ]);
    }
}
