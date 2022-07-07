<?php

namespace App\AccountManagement\Ui\Frontend\User\Controller;

use App\AccountManagement\Application\User\Command\VerifyUserEmail;
use App\AccountManagement\Domain\User\Exception\CannotVerifyUserEmailException;
use App\AccountManagement\Domain\User\Exception\UserNotFoundException;
use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

#[Route('/verify-email',
    name: 'frontend_verify_email',
    requirements: ["_locale" => "en"],
    locale: "en"
)]
class VerifyUserEmailController extends AbstractController
{
    public function __invoke(
        UserRepositoryInterface $userRepository,
        Request                 $request,
        CommandBus              $commandBus
    ): Response
    {
        if (!$id = $request->get('id')) {
            return $this->redirectToRoute('frontend_signup');
        }

        $id = UserId::fromString($id);

        try {
            $command = new VerifyUserEmail([
                'id' => $id,
                'uri' => $request->getUri()
            ]);
            $commandBus->handle($command);
        } catch (UserNotFoundException) {
            $this->addFlash('error', new TranslatableMessage('user.verify_user_email.cannot_verify'));
            return $this->redirectToRoute('frontend_signup');
        } catch (CannotVerifyUserEmailException $exception) {
            $this->addFlash('error', new TranslatableMessage($exception->getMessage(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('frontend_signup');
        }
        
        $user = $userRepository->findById($id);

        $this->addFlash('success', new TranslatableMessage('user.verify_user_email.email_verified'));
        return $this->redirectToRoute('homepage', [
            '_locale' => $user->locale()
        ]);
    }
}
