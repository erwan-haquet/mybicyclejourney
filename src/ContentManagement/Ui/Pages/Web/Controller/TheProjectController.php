<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Domain\Website\Factory\PageFactory;
use App\ContentManagement\Domain\Website\Model\Page;
use App\ContentManagement\Domain\Website\Model\Page\Meta;
use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Marketing\Ui\Launch\Web\Form\RegisterEarlyBirdType;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

#[Route([
    'en_US' => '/the-project',
    'fr_FR' => '/le-projet',
], name: 'the_project')]
class TheProjectController extends AbstractController
{
    public function __invoke(
        Request                 $request,
        CommandBus              $commandBus,
        PageFactory             $pageFactory,
        UrlHelper               $urlHelper,
        PageRepositoryInterface $pageRepository,
    ): Response
    {
        $command = new RegisterEarlyBird();
        $form = $this->createForm(RegisterEarlyBirdType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->dispatch($command);
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.registered_with_success'));
                return $this->redirectToRoute('the_project');
            } catch (EmailIsAlreadyRegistered) {
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.email_is_already_used'));
            }
        }
        
//        $page = $pageFactory->create(
//            type: Page\Type::Static,
//            title: Page\Title::new("L'aventure commence ici ! | My Bicycle Journey"),
//            locale: Locale::new($request->getLocale()),
//            parent:  $pageRepository->findByPath('/fr_FR'),
//            route: new Page\Route(
//                name: 'the_project',
//                path: $request->getPathInfo(),
//                url: $request->getUri(),
//            ),
//            metas: [
//                new Meta\Name\Description("Un peu plus qu'un site, MBJ c'est une aventure en soi. Viens découvrir le projet et pourquoi pas y prendre part ?"),
//                new Meta\Name\Author("Erwan Haquet"),
//                new Meta\OpenGraph\Title("Découvre le projet My Bicycle Journey."),
//                new Meta\OpenGraph\Description("MBJ c'est peu plus qu'un site, c'est une aventure en soi. Alors qu'attends-tu pour rejoindre le projet ?"),
//                new Meta\OpenGraph\Image($urlHelper->getAbsoluteUrl('build/images/homepage/mbj_homepage_og.jpg'))
//            ]
//        );
        
        return $this->render('web/pages/the_project/index.html.twig', [
            'form' => $form->createView(),
            'page' => $pageRepository->findByPath($request->getPathInfo())
        ]);
    }
}
