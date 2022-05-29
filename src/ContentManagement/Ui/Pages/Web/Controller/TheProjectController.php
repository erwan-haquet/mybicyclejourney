<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Domain\Seo\Factory\PageFactory;
use App\ContentManagement\Domain\Seo\Model\OpenGraph;
use App\ContentManagement\Domain\Seo\Model\MetaName;
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

#[Route('/le-projet', name: 'the_project')]
class TheProjectController extends AbstractController
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
                $this->addFlash('success', 'Cool, tu fais désormais partie des early birds 🐦');
                return $this->redirectToRoute('the_project');
            } catch (EmailIsAlreadyRegistered) {
                $this->addFlash('success', 'Ton email est déjà enregistré, mais promis on ne t\'oublie pas 👊');
            }
        }
        $seo = $pageFactory->create(
            title: Title::new("Découvre le projet | My Bicycle Journey"),
            nameMeta: [
                MetaName\Description::new("Un peu plus qu'un site, MBJ c'est avant tout une aventure en soi. Viens découvrir le projet et pourquoi pas y prendre part ?"),
            ],
            openGraph: [
                OpenGraph\Title::new("Découvre le projet My Bicycle Journey."),
                OpenGraph\Description::new("Un peu plus qu'un site, MBJ c'est avant tout une aventure en soi. Viens découvrir le projet et pourquoi pas y prendre part ?"),
                OpenGraph\Image::new($urlHelper->getAbsoluteUrl('build/images/the-project/mbj_the_project_og.jpg'))
            ]
        );

        return $this->render('web/pages/the_project/index.html.twig', [
            'form' => $form->createView(),
            'seo' => $seo
        ]);
    }
}
