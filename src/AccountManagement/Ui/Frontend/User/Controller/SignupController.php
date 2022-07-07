<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use App\AccountManagement\Application\User\Command\Signup;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\AccountManagement\Infrastructure\User\Security\LoginFormAuthenticator;
use App\AccountManagement\Ui\Frontend\User\Form\SignupFormType;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Translation\TranslatableMessage;

#[Route('/signup', name: 'signup')]
class SignupController extends AbstractController
{
    public function __invoke(
        Request                    $request,
        UserRepositoryInterface    $repository,
        CommandBus                 $commandBus,
        UserAuthenticatorInterface $authenticator,
        LoginFormAuthenticator     $formAuthenticator
    ): Response
    {
        $id = $repository->nextIdentity();
        $command = new Signup([
            'id' => $id,
            'locale' => Locale::from($request->getLocale())
        ]);
        $form = $this->createForm(SignupFormType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commandBus->handle($command);

            $this->addFlash('success', new TranslatableMessage('user.signup.registered_with_success'));

            return $authenticator->authenticateUser(
                $repository->findById($id),
                $formAuthenticator,
                $request
            );
        }

        return $this->render('web/user/authentication/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
