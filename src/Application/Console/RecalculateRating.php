<?php

declare(strict_types=1);

namespace App\Application\Console;

use App\Domain\Rating\RatingService;
use App\Entity\Team;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RecalculateRating extends Command
{
    private const DEFAULT_RATING = 1000;
    private GameRepository $gameRepository;
    private PlayerRepository $playerRepository;
    private RatingService $ratingService;

    public function __construct(
        GameRepository $gameRepository,
        PlayerRepository $playerRepository,
        RatingService $ratingService
    ) {
        parent::__construct();
        $this->gameRepository = $gameRepository;
        $this->playerRepository = $playerRepository;
        $this->ratingService = $ratingService;
    }

    protected function configure(): void
    {
        $this->setName('app:recalculate-rating')
            ->setDescription('Обновить рейтинг игроков');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->playerRepository->findAll() as $player) {
            $player->setRating(self::DEFAULT_RATING);
            $this->playerRepository->add($player);
        }

        $prevTeamA = null;
        $prevTeamB = null;
        $teamARating = null;
        $teamBRating = null;
        foreach ($this->gameRepository->findAll() as $game) {
            $teamA = $game->getTeamA();
            $teamB = $game->getTeamB();

            if ($prevTeamA !== $teamA
                || $prevTeamB !== $teamB
                || ($teamARating === null && $teamBRating === null)
            ) {
                $teamARating = $this->getAvgRating($teamA);
                $teamBRating = $this->getAvgRating($teamB);
            }

            $scoreArray = explode(' / ', $game->getScore());
            foreach ($game->getStats() as $stat) {
                $player = $stat->getPlayer();

                if ($player->getTeams()->contains($teamA)) {
                    $isWin = ($scoreArray[0] - $scoreArray[1]) > 0;
                    $teamRatingDiff = ($teamARating - $teamBRating);
                } else {
                    $isWin = ($scoreArray[1] - $scoreArray[0]) > 0;
                    $teamRatingDiff = ($teamBRating - $teamARating);
                }

                $ratingDiff = $this->ratingService->calculateRatingDiff($isWin, $stat, $teamRatingDiff);
                $player->setRating($player->getRating() + $ratingDiff);
                $this->playerRepository->add($player);
            }

            $prevTeamA = $teamA;
            $prevTeamB = $teamB;
        }

        return 1;
    }

    private function getAvgRating(Team $team): float
    {
        $count = 0;
        $rating = 0;
        foreach ($team->getPlayers() as $player) {
            $rating += $player->getRating();
            $count++;
        }

        return ($rating / $count);
    }
}
