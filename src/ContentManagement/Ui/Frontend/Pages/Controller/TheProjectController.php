<?php

namespace App\ContentManagement\Ui\Frontend\Pages\Controller;

use App\ContentManagement\Domain\Website\Repository\PageRepositoryInterface;
use App\Marketing\Application\Launch\Command\RegisterEarlyBird;
use App\Marketing\Domain\Launch\Exception\EmailIsAlreadyRegisteredException;
use App\Marketing\Ui\Frontend\Launch\Form\RegisterEarlyBirdType;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatableMessage;

#[Route([
    'en' => '/the-project',
    'fr' => '/le-projet',
], name: 'the_project')]
class TheProjectController extends AbstractController
{
    public function __invoke(
        Request                 $request,
        CommandBus              $commandBus,
        UrlHelper               $urlHelper,
        PageRepositoryInterface $pageRepository,
    ): Response
    {
        $command = new RegisterEarlyBird([
            'locale' => Locale::from($request->getLocale())
        ]);
        $form = $this->createForm(RegisterEarlyBirdType::class, $command);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $commandBus->handle($command);
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.registered_with_success'));
                return $this->redirectToRoute('the_project');
            } catch (EmailIsAlreadyRegisteredException) {
                $this->addFlash('success', new TranslatableMessage('marketing.early_bird.email_is_already_used'));
            }
        }

        return $this->render('web/pages/the_project/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
