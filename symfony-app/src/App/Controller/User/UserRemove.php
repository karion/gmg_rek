<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserRemove extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler
    ) {}

    #[Route('/users/{id}/delete', name: 'user_remove' )]
    public function __invoke(int $id) : Response
    {
        $user = $this->phoenixApiHandler->getItem($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $success = $this->phoenixApiHandler->removeItem($id);

        if ($success) {
            $this->addFlash('success', 'User removed successfully.');
        } else {
            $this->addFlash('error', 'Failed to remove user.');
        }

        return $this->redirectToRoute('user_list');
    }
}
