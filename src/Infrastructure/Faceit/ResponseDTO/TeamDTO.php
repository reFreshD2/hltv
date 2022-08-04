<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class TeamDTO
{
    /**
     * @JMS\Type("App\Infrastructure\Faceit\ResponseDTO\TeamStatsDTO")
     */
    private TeamStatsDTO $teamStats;
    /**
     * @JMS\Type("array<App\Infrastructure\Faceit\ResponseDTO\PlayerDTO>")
     * @var PlayerDTO[]
     */
    private array $players;

    /**
     * @return PlayerDTO[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getTeamStats(): TeamStatsDTO
    {
        return $this->teamStats;
    }
}
