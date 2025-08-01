<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use GMG\App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCreate extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler,
    ) {
    }

    #[Route('/users/add', name: 'user_create', methods: ['GET', 'POST'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->phoenixApiHandler->createItem($form->getData());

            $this->addFlash('success', 'User created successfully.');

            return $this->redirectToRoute('user_show', ['id' => $user->id]);
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
