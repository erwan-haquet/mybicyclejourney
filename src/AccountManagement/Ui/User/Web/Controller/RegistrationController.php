<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use App\AccountManagement\Application\User\Command\RegisterUser;
use App\AccountManagement\Domain\User\Model\User;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\AccountManagement\Ui\User\Web\Form\RegisterUserType;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegistered;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Library\CQRS\Command\CommandBus;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request                 $request,
        UserRepositoryInterface $userRepository,
        CommandBus              $commandBus
    ): Response
    {
        $command = new RegisterUser();
        $form = $this->createForm(RegisterUserType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->handle($command);
            $this->addFlash('success', new TranslatableMessage(
                'account_management.register_user.registered_with_success',
                [
                    'username' => $command->username
                ]
            ));

            return $this->redirectToRoute('homepage');
        }

        return $this->render('web/account_management/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request                $request,
        TranslatorInterface    $translator,
        EntityManagerInterface $manager
    ): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $repository = $manager->getRepository(User::class);
        $user = $repository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
