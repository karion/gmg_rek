<?php

declare(strict_types=1);

namespace GMG\App\Controller\User;

use GMG\ApiHandler\Service\PhoenixApiHandler;
use GMG\App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserList extends AbstractController
{
    public function __construct(
        private readonly PhoenixApiHandler $phoenixApiHandler,
    ) {
    }

    #[Route('/users', name: 'user_list')]
    public function __invoke(Request $request): Response
    {
        $searchForm = $this->createForm(SearchType::class, null, [
            'method' => 'GET',
            'action' => $this->generateUrl('user_list'),
        ]);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $data = $searchForm->getData() ?? [];

            $filters = array_filter($data, fn ($value) => !is_null($value) && '' !== $value);
        }

        $page = $request->query->getInt('page', 1);
        $users = $this->phoenixApiHandler->getList($page, $filters ?? []);

        return $this->render('user/list.html.twig', [
            'users' => $users['users'] ?? [],
            'pagination' => $users['pagination'] ?? [],
            'searchForm' => $searchForm->createView(),
            'filters' => $filters ?? [],
        ]);
    }
}
