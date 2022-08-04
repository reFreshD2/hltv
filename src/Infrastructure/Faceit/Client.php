<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit;

use App\Infrastructure\Faceit\ResponseDTO\ChampionshipMatchDTO;
use App\Infrastructure\Faceit\ResponseDTO\MatchStatsDTO;
use GuzzleHttp\ClientInterface as HttpClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;

class Client implements ClientInterface
{
    /**
     * @var HttpClientInterface $httpClient
     */
    private $httpClient;
    /**
     * @var string $token
     */
    private $token;
    /**
     * @var string $host
     */
    private $host;
    /**
     * @var LoggerInterface $logger
     */
    private $logger;
    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    public function __construct(
        HttpClientInterface $httpClient,
        string $token,
        string $host,
        LoggerInterface $logger,
        SerializerInterface $serializer
    ) {
        $this->httpClient = $httpClient;
        $this->host = $host;
        $this->token = $token;
        $this->logger = $logger;
        $this->serializer = $serializer;
    }

    /**
     * @inheritDoc
     */
    public function getChampionshipMatches(string $championshipId): ?array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                "$this->host/championships/$championshipId/matches",
                $this->getAuthHeader()
            );
        } catch (GuzzleException $e) {
            $this->logger->error('Error while get championship matches', [
                'championshipId' => $championshipId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }

        $content = json_decode($response->getBody()->getContents(), true);
        $content = $content['items'];
        return $this->serializer->deserialize(
            json_encode($content),
            'array <' . ChampionshipMatchDTO::class . '>',
            'json'
        );
    }

    /**
     * @inheritDoc
     */
    public function getMatchStats(string $matchId): ?array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                "$this->host/matches/$matchId/stats",
                $this->getAuthHeader()
            );
        } catch (GuzzleException $e) {
            $this->logger->error('Error while get match stats', [
                'championshipId' => $matchId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }

        $content = json_decode($response->getBody()->getContents(), true);
        $content = $content['rounds'];
        return $this->serializer->deserialize(json_encode($content), 'array <' . MatchStatsDTO::class . '>', 'json');
    }

    private function getAuthHeader(): array
    {
        return [
            'headers' => [
                'Authorization' => "Bearer $this->token",
            ],
        ];
    }
}
