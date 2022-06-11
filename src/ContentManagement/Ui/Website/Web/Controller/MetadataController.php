<?php

namespace App\ContentManagement\Ui\Website\Web\Controller;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\LocaleAlternate;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata;
use App\ContentManagement\Ui\Website\Web\Dto\OpenGraph;
use Doctrine\ORM\EntityManagerInterface;
use DusanKasan\Knapsack\Collection;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MetadataController extends AbstractController
{
    private PageRepositoryInterface $pageRepository;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface  $entityManager,
        LoggerInterface         $logger
    )
    {
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * This controller render page metadata based on the given urlencoded path.
     */
    public function __invoke(string $encodedPath): Response
    {
        $path = urldecode($encodedPath);
        
        if (!$page = $this->pageRepository->findByPath($path)) {
            // TODO: log the missing page and display a direct 
            //       link to create it via the administration
            $this->logger->error(sprintf('Path "%s" has been reached, but the Page does not exist.', $path));
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $metadata = new Metadata([
            'title' => $page->title(),
            'description' => $page->description(),
            'noindex' => !$page->seo()->shouldIndex(),
            'nofollow' => !$page->seo()->shouldIndex(),
            'localeAlternates' => $this->localeAlternates($page),
            'openGraph' => new OpenGraph([
                'title' => $page->social()->openGraph()->title(),
                'description' => $page->social()->openGraph()->description(),
                'image' => $page->social()->openGraph()->image(),
            ])
        ]);

        return $this->render('web/shared/_metadata.html.twig', [
            'metadata' => $metadata
        ]);
    }

    /**
     * Retrieves the alternate language pages based on the current one.
     *
     * @return LocaleAlternate[]
     */
    private function localeAlternates(Page $page): array
    {
        $result = $this->entityManager
            ->createQueryBuilder()
            ->from(Page::class, 'page')
            ->select('page.route.url AS url')
            ->addSelect('page.locale.language AS locale')
            ->where('page.route.name = :routeName')
            ->setParameter('routeName', $page->routeName())
            ->getQuery()
            ->getArrayResult();

        return Collection::from($result)
            ->map(function (array $item) {
                return new LocaleAlternate([
                    'locale' => $item['locale'],
                    'url' => $item['url'],
                ]);
            })
            ->toArray();
    }
}
