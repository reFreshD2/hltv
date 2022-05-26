<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class PlayerDTO
{
    /**
     * @JMS\Type("string")
     * @var string
     */
    private $playerId;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private $nickname;

    /**
     * @JMS\Type("App\Infrastructure\Faceit\ResponseDTO\PlayerStatsDTO")
     * @var PlayerStatsDTO
     */
    private $playerStats;

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