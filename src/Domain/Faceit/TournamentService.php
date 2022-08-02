<?php

declare(strict_types=1);

namespace App\Domain\Faceit;

use App\Domain\Rating\RatingService;
use App\Entity\Game;
use App\Entity\Map;
use App\Entity\Player;
use App\Entity\Stats;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Infrastructure\Faceit\ClientInterface;
use App\Repository\GameRepository;
use App\Repository\MapRepository;
use App\Repository\PlayerRepository;
use App\Repository\StatsRepository;
use App\Repository\TeamRepository;
use App\Repository\TournamentRepository;

class TournamentService
{
    /**
     * @var ClientInterface
     */
    private $faceitClient;

    /**
     * @var TournamentRepository
     */
    private $tournamentRepository;

    /**
     * @var MapRepository
     */
    private $mapRepository;

    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    /**
     * @var StatsRepository
     */
    private $statsRepository;

    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var RatingService
     */
    private $ratingService;

    public function __construct(
        ClientInterface $faceitClient,
        TournamentRepository $tournamentRepository,
        MapRepository $mapRepository,
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        StatsRepository $statsRepository,
        GameRepository $gameRepository,
        RatingService $ratingService
    ) {
        $this->faceitClient = $faceitClient;
        $this->tournamentRepository = $tournamentRepository;
        $this->mapRepository = $mapRepository;
        $this->teamRepository = $teamRepository;
        $this->playerRepository = $playerRepository;
        $this->statsRepository = $statsRepository;
        $this->gameRepository = $gameRepository;
        $this->ratingService = $ratingService;
    }

    public function addTournament(string $id): void
    {
        $matchesDTO = $this->faceitClient->getChampionshipMatches($id);
        if (!$matchesDTO) {
            return;
        }

        $tournament = new Tournament();
        $tournament->setName($matchesDTO[0]->getCompetitionName());

        $this->tournamentRepository->add($tournament, false);
        foreach ($matchesDTO as $matchDTO) {
            $gamesStatsDTO = $this->faceitClient->getMatchStats($matchDTO->getMatchId());
            if (!$gamesStatsDTO) {
                continue;
            }

            $teamARating = null;
            $teamBRating = null;
            foreach ($gamesStatsDTO as $gameStatsDTO) {
                $match = new Game();
                $match->setTournament($tournament);

                $score = $gameStatsDTO->getRoundStats()->getScore();
                $match->setScore($score);

                $mapName = $gameStatsDTO->getRoundStats()->getMap();
                $map = $this->mapRepository->findOneBy(['name' => $mapName]);
                if (!$map) {
                    $map = new Map();
                    $map->setName($mapName);
                    $this->mapRepository->add($map);
                }
                $match->setMap($map);
                $tournament->addMap($map);
                $this->gameRepository->add($match, false);

                $teamsDTO = $gameStatsDTO->getTeams();
                foreach ($teamsDTO as $teamDTO) {
                    $teamName = $teamDTO->getTeamStats()->getTeamName();
                    $team = $this->teamRepository->findOneBy(['name' => $teamName]);
                    if (!$team) {
                        $team = new Team();
                        $team->setName($teamName);
                    }
                    $playersDTO = $teamDTO->getPlayers();
                    foreach ($playersDTO as $playerDTO) {
                        $playerId = $playerDTO->getPlayerId();
                        $player = $this->playerRepository->findOneBy(['faceitId' => $playerId]);
                        if (!$player) {
                            $player = new Player();
                            $player->setFaceitId($playerId);
                            $player->setNickname($playerDTO->getNickname());
                            $this->playerRepository->add($player, false);
                        }
                        $team->addPlayer($player);

                        $playerStatsDTO = $playerDTO->getPlayerStats();
                        $stats = new Stats();
                        $stats->setAssists($playerStatsDTO->getAssists());
                        $stats->setDeaths($playerStatsDTO->getDeaths());
                        $stats->setHs($playerStatsDTO->getHeadshots());
                        $stats->setKills($playerStatsDTO->getKills());
                        $stats->setMvp($playerStatsDTO->getMvp());
                        $stats->setPentaKills($playerStatsDTO->getPentaKills());
                        $stats->setQuadroKills($playerStatsDTO->getQuadroKills());
                        $stats->setTripleKills($playerStatsDTO->getTripleKills());
                        $stats->setPlayer($player);
                        $stats->setGame($match);

                        $this->statsRepository->add($stats, false);
                        $match->addStat($stats);
                    }

                    if ($match->getTeamA()) {
                        $match->setTeamB($team);
                        if (!$teamBRating) {
                            $teamBRating = $this->getAvgRating($team);
                        }
                    } else {
                        $match->setTeamA($team);
                        if (!$teamARating) {
                            $teamARating = $this->getAvgRating($team);
                        }
                    }
                    $this->teamRepository->add($team, false);
                    $tournament->addTeam($team);
                }

                $teamA = $match->getTeamA();
                $scoreArray = explode(' / ', $score);
                foreach ($match->getStats() as $stat) {
                    $player = $stat->getPlayer();

                    if ($player->getTeams()->contains($teamA)) {
                        $isWin = $scoreArray[0] - $scoreArray[1] > 0;
                        $teamRatingDiff = $teamARating - $teamBRating;
                    } else {
                        $isWin = $scoreArray[1] - $scoreArray[0] > 0;
                        $teamRatingDiff = $teamBRating - $teamARating;
                    }

                    $ratingDiff = $this->ratingService->calculateRatingDiff($isWin, $stat, $teamRatingDiff);
                    $player->setRating($player->getRating() + $ratingDiff);
                    $this->playerRepository->add($player);
                    $this->statsRepository->add($stat);
                }

                $this->gameRepository->add($match);
                $tournament->addGame($match);
            }
        }

        $this->tournamentRepository->add($tournament);
    }

    private function getAvgRating(Team $team): float
    {
        $count = 0;
        $rating = 0;
        foreach ($team->getPlayers() as $player) {
            $rating += $player->getRating();
            $count++;
        }

        return $rating / $count;
    }
}
