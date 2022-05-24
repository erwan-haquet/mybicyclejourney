<?php

namespace App\ContentManagement\Ui\Homepage\Web\Controller;

use App\ContentManagement\Ui\Homepage\Web\Form\RegisterEarlyBirdType;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'homepage')]
class ShowController extends AbstractController
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
            $commandBus->dispatch($command);
            $this->addFlash('success', 'Cool, te voila désormais early bird 🐦');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
