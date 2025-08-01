<?php

declare(strict_types=1);

namespace GMG\ApiHandler\Service;

use GMG\ApiHandler\DTO\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhoenixApiHandler
{
    private const LIST_USERS = '/api/users';
    private const GET_USER = '/api/users/%d';

    public function __construct(
        private readonly DenormalizerInterface $denormalizer,
        private readonly NormalizerInterface $normalizer,
        private readonly HttpClientInterface $client,
        private readonly string $phoenixBaseUrl,
    ) {
    }

    /**
     * @param array<string, mixed> $query
     *
     * @return User[]|array
     */
    public function getList(int $page = 1, array $query = []): array
    {
        $query['page'] = $page;

        if (isset($query['birthdate_from']) && '' !== $query['birthdate_from']) {
            $query['birthdate_from'] = $query['birthdate_from']->format('Y-m-d');
        }
        if (isset($query['birthdate_to']) && '' !== $query['birthdate_to']) {
            $query['birthdate_to'] = $query['birthdate_to']->format('Y-m-d');
        }

        $response = $this->client->request(
            'GET',
            $this->phoenixBaseUrl.self::LIST_USERS,
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
                    User::class.'[]'
                ),
                'pagination' => $data['meta'] ?? [],
            ];
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }

    public function getItem(int $id): ?User
    {
        $response = $this->client->request(
            'GET',
            $this->phoenixBaseUrl.sprintf(self::GET_USER, $id),
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

        if (404 === $statusCode) {
            // Jeśli użytkownik nie został znaleziony, zwróć null
            return null;
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }

    public function removeItem(int $id): bool
    {
        $response = $this->client->request(
            'DELETE',
            $this->phoenixBaseUrl.sprintf(self::GET_USER, $id),
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

    public function updateItem(int $id, User $user): bool
    {
        $response = $this->client->request(
            'PUT',
            $this->phoenixBaseUrl.sprintf(self::GET_USER, $id),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $this->normalizer->normalize(
                    ['user' => $user],
                    JsonEncoder::FORMAT,
                    ['groups' => ['user:write']]
                ),
            ]
        );

        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return true;
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas aktualizacji użytkownika: {$statusCode}");
    }

    public function createItem(User $user): User
    {
        $response = $this->client->request(
            'POST',
            $this->phoenixBaseUrl.self::LIST_USERS,
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $this->normalizer->normalize(
                    ['user' => $user],
                    JsonEncoder::FORMAT,
                    ['groups' => ['user:write']]
                ),
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
        throw new \RuntimeException("Błąd podczas tworzenia użytkownika: {$statusCode}");
    }
}
