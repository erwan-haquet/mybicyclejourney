<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use App\AccountManagement\Application\User\Command\RegisterUser;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\AccountManagement\Ui\User\Web\Form\RegisterUserType;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

#[Route('/register', name: 'register')]
class RegisterUserController extends AbstractController
{
    public function __invoke(
        Request                 $request,
        UserRepositoryInterface $repository,
        CommandBus              $commandBus
    ): Response
    {
        $command = new RegisterUser([
            'id' => $repository->nextIdentity(),
            'locale' => Locale::from($request->getLocale())
        ]);
        $form = $this->createForm(RegisterUserType::class, $command);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($command);

            $this->addFlash('success', new TranslatableMessage(
                'account_management.register_user.registered_with_success',
                ['username' => $command->username]
            ));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('web/account_management/registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
