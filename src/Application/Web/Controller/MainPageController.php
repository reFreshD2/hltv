<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainPageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('web/index.html.twig');
    }
}
