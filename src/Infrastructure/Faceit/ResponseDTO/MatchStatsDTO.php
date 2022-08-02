<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class MatchStatsDTO
{
    /**
     * @JMS\Type("App\Infrastructure\Faceit\ResponseDTO\RoundStatsDTO")
     * @var RoundStatsDTO
     */
    private $roundStats;

    /**
     * @JMS\Type("array<App\Infrastructure\Faceit\ResponseDTO\TeamDTO>")
     * @var array
     */
    private $teams;

    /**
     * @return mixed
     */
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
