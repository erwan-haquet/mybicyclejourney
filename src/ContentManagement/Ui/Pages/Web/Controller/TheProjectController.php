<?php

namespace App\ContentManagement\Ui\Pages\Web\Controller;

use App\ContentManagement\Ui\Pages\Web\Form\RegisterEarlyBirdType;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: ['en' => '/the-project', 'fr' => '/le-projet'], 
    name: 'the_project'
)]
class TheProjectController extends AbstractController
{
    public function __invoke(
        Request    $request,
        CommandBus $commandBus
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

        return $this->render('web/pages/the_project/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
