<?php

declare(strict_types=1);

namespace App\Domain\Statistic\DTO;

use App\Entity\Player;

class TopPlayerDTO
{
    /**
     * @var Player
     */
    private $player;
    /**
     * @var float
     */
    private $kda;
    /**
     * @var int
     */
    private $mapPlayed;

    public function __construct(Player $player, float $kda, int $mapPlayed)
    {
        $this->player = $player;
        $this->kda = $kda;
        $this->mapPlayed = $mapPlayed;
    }

    public function getKda(): float
    {
        return $this->kda;
    }

    public function getMapPlayed(): int
    {
        return $this->mapPlayed;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setKda(float $kda): void
    {
        $this->kda = $kda;
    }

    public function incMapPlayed(): void
    {
        $this->mapPlayed++;
    }
}
