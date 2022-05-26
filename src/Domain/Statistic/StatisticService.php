<?php

declare(strict_types=1);

namespace App\Domain\Statistic;

use App\Domain\Statistic\DTO\PlayerStatsDTO;
use App\Domain\Statistic\DTO\TeamStatsDTO;
use App\Domain\Statistic\DTO\TopPlayerDTO;
use App\Entity\Player;
use App\Entity\Team;
use App\Entity\Tournament;

class StatisticService
{
    /**
     * @return TopPlayerDTO[]
     */
    public function getTournamentTopPlayer(Tournament $tournament): array
    {
        /**
         * @var TopPlayerDTO[] $players
         */
        $players = [];
        foreach ($tournament->getGames() as $game) {
            foreach ($game->getStats() as $stat) {
                $kda = round(($stat->getKills() + $stat->getAssists()) / $stat->getDeaths(), 2);
                if (!isset($players[$stat->getPlayer()->getId()])) {
                    $players[$stat->getPlayer()->getId()] = new TopPlayerDTO($stat->getPlayer(), $kda, 1);
                } else {
                    $dto = $players[$stat->getPlayer()->getId()];
                    $dto->incMapPlayed();
                    $kda = round(($dto->getKda() + $kda) / 2, 2);
                    $dto->setKda($kda);
                    $players[$stat->getPlayer()->getId()] = $dto;
                }
            }
        }

        usort($players, function (TopPlayerDTO $item1, TopPlayerDTO $item2) {
            if ($item1->getKda() === $item2->getKda()) {
                return 0;
            }

            return $item1->getKda() > $item2->getKda() ? -1 : 1;
        });

        return array_slice($players, 0, 8);
    }

    public function getTeamStats(Team $team): TeamStatsDTO
    {
        $totalKills = 0;
        $totalDeaths = 0;
        $totalAssists = 0;
        $roundPlayed = 0;
        $wins = 0;
        $loses = 0;
        $avgRating = 0;

        foreach ($team->getGames() as $game) {
            $scoreArray = explode(' / ', $game->getScore());
            $roundPlayed += $scoreArray[0] + $scoreArray[1];
            if ($scoreArray[0] > $scoreArray[1] xor $team === $game->getTeamA()) {
                $loses++;
            } else {
                $wins++;
            }
            foreach ($game->getStats() as $stat) {
                if ($stat->getPlayer()->getTeams()->last() !== $team) {
                    continue;
                }

                $totalKills += $stat->getKills();
                $totalAssists += $stat->getAssists();
                $totalDeaths += $stat->getDeaths();
            }
        }

        foreach ($team->getPlayers() as $player) {
            $avgRating += $player->getRating();
        }
        $avgRating /= $team->getPlayers()->count();

        return (new TeamStatsDTO($team))
            ->addTotalKills($totalKills)
            ->addTotalAssist($totalAssists)
            ->addTotalDeaths($totalDeaths)
            ->addRoundPlayed($roundPlayed)
            ->addWins($wins)
            ->addLoses($loses)
            ->addRating($avgRating);
    }

    public function getPlayerStats(Player $player)
    {
        $dto = new PlayerStatsDTO($player);
        $allKills = 0;
        $allDeaths = 0;
        $allAssists = 0;
        $allHs = 0;
        $roundPlayed = 0;
        $mapPlayed = 0;
        $allMvps = 0;
        $allMultikills = 0;

        foreach ($player->getStats() as $stat) {
            $allKills += $stat->getKills();
            $allDeaths += $stat->getDeaths();
            $allAssists += $stat->getAssists();
            $allHs += $stat->getHs();
            $allMultikills += $stat->getTripleKills() + $stat->getQuadroKills() + $stat->getPentaKills();
            $allMvps += $stat->getMvp();
            $mapPlayed++;
            $match = $stat->getGame();
            $scoreArray =  explode(' / ', $match->getScore());
            $roundPlayed += $scoreArray[0] + $scoreArray[1];
        }

        return $dto->setAllAssists($allAssists)
            ->setAllDeaths($allDeaths)
            ->setAllHs($allHs)
            ->setAllKills($allKills)
            ->setAllMvps($allMvps)
            ->setAllMultikills($allMultikills)
            ->setRoundPlayed($roundPlayed)
            ->setMapPlayed($mapPlayed);
    }
}