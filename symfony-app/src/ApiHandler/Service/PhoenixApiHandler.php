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
            return $this->denormalizer->denormalize(
                $response->toArray()['data'],
                User::class . '[]'
            );
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }

    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 200 && $statusCode < 300) {
            return $response->toArray();
        }

        // Możesz tu rzucić wyjątkiem lub zwrócić błąd w inny sposób
        throw new \RuntimeException("Błąd podczas zapytania do API: {$statusCode}");
    }
}
