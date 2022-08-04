<?php

declare(strict_types=1);

namespace App\Domain\Statistic\DTO;

use App\Entity\Team;

class TeamStatsDTO
{
    private Team $team;
    private float $rating;
    private int $wins;
    private int $loses;
    private int $totalKills;
    private int $totalDeaths;
    private int $totalAssists;
    private int $roundPlayed;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function getTeam(): Team
    {
        return $this->team;
    }

    public function getMapsPlayed(): int
    {
        return ($this->wins + $this->loses);
    }

    public function getKdDiff(): int
    {
        return ($this->totalKills - $this->totalDeaths);
    }

    public function getKda(): float
    {
        return round((($this->totalKills + $this->totalAssists) / $this->getTotalDeaths()), 2);
    }

    public function getRating(): float
    {
        return round($this->rating, 2);
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function getLoses(): int
    {
        return $this->loses;
    }

    public function getTotalKills(): int
    {
        return $this->totalKills;
    }

    public function getTotalDeaths(): int
    {
        return $this->totalDeaths;
    }

    public function getTotalAssists(): int
    {
        return $this->totalAssists;
    }

    public function getRoundPlayed(): int
    {
        return $this->roundPlayed;
    }

    public function addTotalKills(int $totalKills): self
    {
        $this->totalKills = $totalKills;

        return $this;
    }

    public function addTotalAssist(int $totalAssists): self
    {
        $this->totalAssists = $totalAssists;

        return $this;
    }

    public function addTotalDeaths(int $totalDeaths): self
    {
        $this->totalDeaths = $totalDeaths;

        return $this;
    }

    public function addRoundPlayed(int $roundPlayed): self
    {
        $this->roundPlayed = $roundPlayed;

        return $this;
    }

    public function addWins(int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function addLoses(int $loses): self
    {
        $this->loses = $loses;

        return $this;
    }

    public function addRating(float $avgRating): self
    {
        $this->rating = $avgRating;

        return $this;
    }
}
