<?php

namespace App\ContentManagement\Infrastructure\Website\EventSubscriber;

use App\ContentManagement\Domain\Website\Model\Page\Page;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\ContentManagement\Ui\Website\Web\Dto\Breadcrumbs\Breadcrumbs;
use App\ContentManagement\Ui\Website\Web\Dto\LocaleAlternate;
use App\ContentManagement\Ui\Website\Web\Dto\Metadata;
use App\ContentManagement\Ui\Website\Web\Dto\OpenGraph;
use Doctrine\ORM\EntityManagerInterface;
use DusanKasan\Knapsack\Collection;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

/**
 * This service injects page metadata into the twig globals which is
 * from now on ready to be used globally on the templates.
 * @path templates/web/shared/_metadata.html.twig
 */
class MetadataInjector implements EventSubscriberInterface
{
    private Environment $twig;
    private PageRepositoryInterface $pageRepository;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    public function __construct(
        Environment             $twig,
        PageRepositoryInterface $pageRepository,
        EntityManagerInterface  $entityManager,
        LoggerInterface         $logger
    )
    {
        $this->twig = $twig;
        $this->pageRepository = $pageRepository;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $path = $event->getRequest()->getPathInfo();

        if (!$page = $this->pageRepository->findByPath($path)) {
            // TODO: log the missing page and display a direct 
            //       link to create it via the administration
            $this->logger->error(sprintf('Missing %s for path : "%s"', Page::class, $path));
            return;
        }

        $metadata = new Metadata([
            'title' => $page->title(),
            'description' => $page->description(),
            'noindex' => !$page->seo()->shouldIndex(),
            'nofollow' => !$page->seo()->shouldIndex(),
            'localeAlternates' => $this->localeAlternates($page),
            'breadcrumbs' => Breadcrumbs::fromPage($page),
            'openGraph' => new OpenGraph([
                'title' => $page->social()->openGraph()->title(),
                'description' => $page->social()->openGraph()->description(),
                'image' => $page->social()->openGraph()->image(),
            ])
        ]);

        $this->twig->addGlobal('metadata', $metadata);
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

    #[ArrayShape([KernelEvents::CONTROLLER => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
