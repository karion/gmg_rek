<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use GMG\App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserShow extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler,
    ) {
    }

    #[Route('/users/{id}', name: 'user_show', methods: ['GET'])]
    public function __invoke(int $id, Request $request): Response
    {

        $user = $this->phoenixApiHandler->getItem($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        $form = $this->createForm(UserType::class, $user);

        return $this->render('user/form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
