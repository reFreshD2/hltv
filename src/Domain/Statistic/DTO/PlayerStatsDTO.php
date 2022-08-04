<?php

declare(strict_types=1);

namespace App\Domain\Statistic\DTO;

use App\Entity\Player;

class PlayerStatsDTO
{
    private Player $player;
    private int $allKills;
    private int $allAssists;
    private int $allDeaths;
    private int $mapPlayed;
    private int $roundPlayed;
    private int $allMultikills;
    private int $allMvps;
    private int $allHs;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getAllKills(): int
    {
        return $this->allKills;
    }

    public function setAllKills(int $allKills): self
    {
        $this->allKills = $allKills;
        return $this;
    }

    public function getAllAssists(): int
    {
        return $this->allAssists;
    }

    public function setAllAssists(int $allAssists): self
    {
        $this->allAssists = $allAssists;
        return $this;
    }

    public function getAllDeaths(): int
    {
        return $this->allDeaths;
    }

    public function setAllDeaths(int $allDeaths): self
    {
        $this->allDeaths = $allDeaths;
        return $this;
    }

    public function getMapPlayed(): int
    {
        return $this->mapPlayed;
    }

    public function setMapPlayed(int $mapPlayed): self
    {
        $this->mapPlayed = $mapPlayed;
        return $this;
    }

    public function getRoundPlayed(): int
    {
        return $this->roundPlayed;
    }

    public function setRoundPlayed(int $roundPlayed): self
    {
        $this->roundPlayed = $roundPlayed;
        return $this;
    }

    public function getAllMultikills(): int
    {
        return $this->allMultikills;
    }

    public function setAllMultikills(int $allMultikills): self
    {
        $this->allMultikills = $allMultikills;
        return $this;
    }

    public function getAllMvps(): int
    {
        return $this->allMvps;
    }

    public function setAllMvps(int $allMvps): self
    {
        $this->allMvps = $allMvps;
        return $this;
    }

    public function getAllHs(): int
    {
        return $this->allHs;
    }

    public function setAllHs(int $allHs): self
    {
        $this->allHs = $allHs;
        return $this;
    }

    public function getKda(): float
    {
        return round((($this->allKills + $this->allAssists) / $this->allDeaths), 2);
    }

    public function getKpr(): float
    {
        return round(($this->allKills / $this->roundPlayed), 2);
    }

    public function getApr(): float
    {
        return round(($this->allAssists / $this->roundPlayed), 2);
    }

    public function getDpr(): float
    {
        return round(($this->allDeaths / $this->roundPlayed), 2);
    }

    public function getHsPersent(): float
    {
        return (round(($this->allHs / $this->allKills), 2) * 100);
    }

    public function getKd(): float
    {
        return round(($this->allKills / $this->allDeaths), 2);
    }
}
