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
    name: 'homepage'
)]
class TheProjectController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('web/pages/the_project/index.html.twig');
    }
}
