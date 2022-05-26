<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 */
class Stats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="stats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="integer")
     */
    private $kills;

    /**
     * @ORM\Column(type="integer")
     */
    private $assists;

    /**
     * @ORM\Column(type="integer")
     */
    private $deaths;

    /**
     * @ORM\Column(type="integer")
     */
    private $hs;

    /**
     * @ORM\Column(type="integer")
     */
    private $mvp;

    /**
     * @ORM\Column(type="integer")
     */
    private $tripleKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $quadroKills;

    /**
     * @ORM\Column(type="integer")
     */
    private $pentaKills;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getKills(): ?int
    {
        return $this->kills;
    }

    public function setKills(int $kills): self
    {
        $this->kills = $kills;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(int $assists): self
    {
        $this->assists = $assists;

        return $this;
    }

    public function getDeaths(): ?int
    {
        return $this->deaths;
    }

    public function setDeaths(int $deaths): self
    {
        $this->deaths = $deaths;

        return $this;
    }

    public function getHs(): ?int
    {
        return $this->hs;
    }

    public function setHs(int $hs): self
    {
        $this->hs = $hs;

        return $this;
    }

    public function getMvp(): ?int
    {
        return $this->mvp;
    }

    public function setMvp(int $mvp): self
    {
        $this->mvp = $mvp;

        return $this;
    }

    public function getTripleKills(): ?int
    {
        return $this->tripleKills;
    }

    public function setTripleKills(int $tripleKills): self
    {
        $this->tripleKills = $tripleKills;

        return $this;
    }

    public function getQuadroKills(): ?int
    {
        return $this->quadroKills;
    }

    public function setQuadroKills(int $quadroKills): self
    {
        $this->quadroKills = $quadroKills;

        return $this;
    }

    public function getPentaKills(): ?int
    {
        return $this->pentaKills;
    }

    public function setPentaKills(int $pentaKills): self
    {
        $this->pentaKills = $pentaKills;

        return $this;
    }
}
