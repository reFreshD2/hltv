<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;
    /**
     * @ORM\ManyToMany(targetEntity=Player::class, inversedBy="teams")
     */
    private ArrayCollection $players;
    /**
     * @ORM\ManyToMany(targetEntity=Tournament::class, mappedBy="teams")
     */
    private ArrayCollection $tournaments;
    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamA")
     */
    private ArrayCollection $gamesAsATeam;
    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="teamB")
     */
    private ArrayCollection $gamesAsBTeam;
    private ArrayCollection $games;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->gamesAsATeam = new ArrayCollection();
        $this->gamesAsBTeam = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if ($this->players->contains($player) === false) {
            $this->players[] = $player;
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        $this->players->removeElement($player);

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): self
    {
        if ($this->tournaments->contains($tournament) === false) {
            $this->tournaments[] = $tournament;
            $tournament->addTeam($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): self
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        $this->games = new ArrayCollection(array_merge($this->gamesAsATeam->toArray(), $this->gamesAsBTeam->toArray()));
        return $this->games;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTeamA() === $this) {
                $game->setTeamA(null);
            }
        }

        return $this;
    }
}
