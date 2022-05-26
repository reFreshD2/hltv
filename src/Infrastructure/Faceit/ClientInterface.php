<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit;

use App\Infrastructure\Faceit\ResponseDTO\ChampionshipMatchDTO;
use App\Infrastructure\Faceit\ResponseDTO\MatchStatsDTO;

interface ClientInterface
{
    /**
     * @param string $championshipId
     * @return ChampionshipMatchDTO[]|null
     */
    public function getChampionshipMatches(string $championshipId): ?array;

    /**
     * @param string $matchId
     * @return MatchStatsDTO[]|null
     */
    public function getMatchStats(string $matchId): ?array;
}