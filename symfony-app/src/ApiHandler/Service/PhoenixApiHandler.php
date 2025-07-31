<?php

declare(strict_types=1);

namespace GMG\ApiHandler\Service;

use GMG\ApiHandler\DTO\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PhoenixApiHandler
{
    private const LIST_USERS = '/api/users';
    private const GET_USER = '/api/users/%d';

    public function __construct(
        private readonly DenormalizerInterface $denormalizer,
        private readonly HttpClientInterface $client,
        private readonly string $phoenixBaseUrl,

    ) {}

    public function getList(array $query = []): array
    {
        $response = $this->client->request(
            'GET',
            $this->phoenixBaseUrl . self::LIST_USERS,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'query' => $query,
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {

            $data = $response->toArray();
            return [
                'users' => $this->denormalizer->denormalize(
                    $data['data'],
                    User::class . '[]'
                ),
                'pagination' => $data['meta'] ?? [],
            ];
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }

    public function getItem(int $id): User
    {
        $response = $this->client->request(
            'GET',
            $this->phoenixBaseUrl . sprintf(self::GET_USER, $id),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {

            $data = $response->toArray();

            return $this->denormalizer->denormalize(
                $data['data'],
                User::class
            );
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }

    public function removeItem(int $id): bool
    {
        $response = $this->client->request(
            'DELETE',
            $this->phoenixBaseUrl . sprintf(self::GET_USER, $id),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return true;
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas usuwania użytkownika: {$statusCode}");
    }
}
