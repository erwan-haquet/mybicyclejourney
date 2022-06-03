<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Domain\Seo\Factory\PageFactory;
use App\ContentManagement\Domain\Seo\Model\Title;
use App\ContentManagement\Ui\Pages\Web\Form\RegisterEarlyBirdType;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use App\ContentManagement\Domain\Seo\Model\OpenGraph;
use App\ContentManagement\Domain\Seo\Model\MetaName;
use Symfony\Component\Translation\TranslatableMessage;

#[Route('/', name: 'homepage')]
class HomepageController extends AbstractController
{
    public function __invoke(
        Request     $request,
        CommandBus  $commandBus,
        PageFactory $pageFactory,
        UrlHelper   $urlHelper
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

        $seo = $pageFactory->create(
            title: Title::new("L'aventure commence ici ! | My Bicycle Journey"),
            nameMeta: [
                MetaName\Description::new("Raconte nous tes plus beaux périples à vélo, le plus simplement du monde. Tu n'as plus qu'à profiter de la route, désormais 5 minutes au bivouac te suffiront pour envoyer des nouvelles à tes proches."),
                MetaName\Author::new("Erwan Haquet"),
            ],
            openGraph: [
                OpenGraph\Title::new("Partage tes plus belles aventures à vélo, en toute simplicité."),
                OpenGraph\Description::new("Profite de la route, désormais 5 minutes au bivouac te suffiront pour envoyer des nouvelles à tes proches. Raconte nous tes plus beaux périples à vélo, le plus simplement du monde."),
                OpenGraph\Image::new($urlHelper->getAbsoluteUrl('build/images/homepage/mbj_homepage_og.jpg'))
            ]
        );

        return $this->render('web/pages/homepage/index.html.twig', [
            'form' => $form->createView(),
            'seo' => $seo
        ]);
    }
}
