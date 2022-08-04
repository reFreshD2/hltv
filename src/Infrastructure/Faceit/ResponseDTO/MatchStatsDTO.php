<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class MatchStatsDTO
{
    /**
     * @JMS\Type("App\Infrastructure\Faceit\ResponseDTO\RoundStatsDTO")
     */
    private RoundStatsDTO $roundStats;
    /**
     * @JMS\Type("array<App\Infrastructure\Faceit\ResponseDTO\TeamDTO>")
     * @var TeamDTO[]
     */
    private array $teams;

    public function getRoundStats(): RoundStatsDTO
    {
        return $this->roundStats;
    }

    /**
     * @return TeamDTO[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}
