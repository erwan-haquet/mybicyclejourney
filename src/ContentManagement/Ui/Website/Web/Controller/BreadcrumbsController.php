<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs\Breadcrumbs;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/** 
 * 
 */
class BreadcrumbsController extends AbstractController
{
    private PageRepositoryInterface $pageRepository;
    private LoggerInterface $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        LoggerInterface         $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->logger = $logger;
    }

    /**
     * Render the breadcrumbs based on the given urlencoded path.
     * @see "web/shared/_breadcrumbs.html.twig"
     */
    public function __invoke(string $encodedPath): Response
    {
        $path = urldecode($encodedPath);
        
        if (!$page = $this->pageRepository->findByPath($path)) {
            $this->logger->error(sprintf(
                'Tried to render breadcrumbs for path "%s", but the Page does not exists.',
                $path
            ));
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->render('web/shared/_breadcrumbs.html.twig', [
            'breadcrumbs' => Breadcrumbs::fromPage($page)
        ]);
    }
}
