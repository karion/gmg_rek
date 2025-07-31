<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use GMG\App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserUpdate extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler
    ) {}

    #[Route('/users/{id}', name: 'user_update', methods: ['POST'])]
    public function __invoke(int $id, Request $request) : Response
    {
        $user = $this->phoenixApiHandler->getItem($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->phoenixApiHandler->updateItem($id, $form->getData());

            $this->addFlash('success', 'User updated successfully.');
            return $this->redirectToRoute('user_show', ['id' => $id]);
        }

        return $this->render('user/form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
