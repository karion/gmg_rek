<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserList extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler
    ) {}

    #[Route('/users', name: 'user_list')]
    public function __invoke() : Response
    {
        $users = $this->phoenixApiHandler->getList();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
