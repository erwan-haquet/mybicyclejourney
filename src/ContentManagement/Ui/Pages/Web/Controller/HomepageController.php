<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Domain\Website\Factory\PageFactory;
use App\ContentManagement\Domain\Website\Model\Page\PageId;
use App\ContentManagement\Domain\Website\Model\Page\Path;
use App\ContentManagement\Domain\Website\Model\Page\Title;
use App\ContentManagement\Domain\Website\Model\Page\Type;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Ui\Launch\Web\Form\RegisterEarlyBirdType;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use App\ContentManagement\Domain\Website\Model\Page\Meta;

#[Route('/', name: 'homepage')]
class HomepageController extends AbstractController
{
    public function __invoke(
        Request                 $request,
        CommandBus              $commandBus,
        PageFactory             $pageFactory,
        PageRepositoryInterface $pageRepository,
        UrlHelper               $urlHelper
    ): Response
    {
        $command = new RegisterEarlyBird();
        $form = $this->createForm(RegisterEarlyBirdType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->dispatch($command);
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.registered_with_success'));
                return $this->redirectToRoute('homepage');
            } catch (EmailIsAlreadyRegistered) {
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.email_is_already_used'));
            }
        }

//        $page = $pageFactory->create(
//            title: Title::new("Découvre le projet | My Bicycle Journey"),
//            type: Type::Static,
//            path: Path::new($request->getPathInfo()),
//            parent: null,
//            metas: new Meta\Collection([
//                new Meta\Name\Description("Raconte nous tes plus beaux périples à vélo, le plus simplement du monde. Tu n'as plus qu'à profiter de la route, désormais 5 minutes au bivouac te suffiront pour envoyer des nouvelles à tes proches."),
//                new Meta\Name\Author("Erwan Haquet"),
//                new Meta\OpenGraph\Title("Partage tes plus belles aventures à vélo, en toute simplicité."),
//                new Meta\OpenGraph\Description("Profite de la route, désormais 5 minutes au bivouac te suffiront pour envoyer des nouvelles à tes proches. Raconte nous tes plus beaux périples à vélo, le plus simplement du monde."),
//                new Meta\OpenGraph\Image($urlHelper->getAbsoluteUrl('build/images/homepage/mbj_homepage_og.jpg'))
//            ])
//        );

        $page = $pageRepository->findById(PageId::fromString('35189497-5f48-4726-b505-228ba1b0ce19'));

        return $this->render('web/pages/homepage/index.html.twig', [
            'form' => $form->createView(),
            'page' => $page
        ]);
    }
}
