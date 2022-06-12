<?php

namespace App\AccountManagement\Ui\User\Web\Controller;

use App\AccountManagement\Application\User\Command\VerifyUserEmail;
use App\AccountManagement\Domain\User\Exception\CannotVerifyUserEmail;
use App\AccountManagement\Domain\User\Exception\UserNotFound;
use App\AccountManagement\Domain\User\Model\UserId;
use Doctrine\ORM\EntityManagerInterface;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

class VerifyUserEmailController extends AbstractController
{
    #[Route('/verify-email', name: 'verify_email')]
    public function __invoke(
        Request                $request,
        TranslatorInterface    $translator,
        CommandBus             $commandBus,
        EntityManagerInterface $manager
    ): Response
    {
        if (!$id = $request->get('id')) {
            return $this->redirectToRoute('signup');
        }

        try {
            $command = new VerifyUserEmail([
                'id' => UserId::fromString($id),
                'uri' => $request->getUri()
            ]);
            $commandBus->handle($command);
        } catch (UserNotFound $exception) {
            $this->addFlash('error', new TranslatableMessage('account_management.verify_user_email.user_not_found'));
            return $this->redirectToRoute('signup');
        } catch (CannotVerifyUserEmail $exception) {
            $this->addFlash('error', new TranslatableMessage($exception->getMessage(), [], 'VerifyEmailBundle'));
            return $this->redirectToRoute('signup');
        }

        $this->addFlash('success', new TranslatableMessage('account_management.verify_user_email.email_verified'));
        return $this->redirectToRoute('homepage');
    }
}
