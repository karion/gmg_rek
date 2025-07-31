<?php

declare(strict_types=1);

namespace GMG\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class Main extends AbstractController
{
    #[Route('/', name: 'main')]
    public function __invoke(): RedirectResponse
    {
        return $this->redirectToRoute('user_list');
    }
}
