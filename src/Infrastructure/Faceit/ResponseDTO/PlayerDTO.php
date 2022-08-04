<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class PlayerDTO
{
    /**
     * @JMS\Type("string")
     */
    private string $playerId;
    /**
     * @JMS\Type("string")
     */
    private string $nickname;
    /**
     * @JMS\Type("App\Infrastructure\Faceit\ResponseDTO\PlayerStatsDTO")
     */
    private PlayerStatsDTO $playerStats;

    public function getPlayerId(): string
    {
        return $this->playerId;
    }

    public function getPlayerStats(): PlayerStatsDTO
    {
        return $this->playerStats;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
}
