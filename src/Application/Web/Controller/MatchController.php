<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use App\Entity\Stats;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MatchController extends AbstractController
{
    private GameRepository $gameRepository;

    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    public function __invoke(string $id): Response
    {
        $match = $this->gameRepository->findOneBy(['id' => $id]);
        $scoreArray = explode(' / ', $match->getScore());
        $teamAStats = array_filter(
            $match->getStats()->toArray(), function (Stats $stat) use ($match) {
            return $stat->getPlayer()->getTeams()->last() === $match->getTeamA();
            }
        );
        $teamBStats = array_filter(
            $match->getStats()->toArray(), function (Stats $stat) use ($match) {
            return $stat->getPlayer()->getTeams()->last() === $match->getTeamB();
            }
        );
        usort(
            $teamAStats, function (Stats $a, Stats $b) {
            return ($a->getKills() >= $b->getKills() ? -1 : 1);
            }
        );
        usort(
            $teamBStats, function (Stats $a, Stats $b) {
            return ($a->getKills() >= $b->getKills() ? -1 : 1);
            }
        );

        return $this->render(
            'web/match/match-view-page.html.twig', [
                'match' => $match,
                'teamAScore' => $scoreArray[0],
                'teamBScore' => $scoreArray[1],
                'teamAStats' => $teamAStats,
                'teamBStats' => $teamBStats,
            ]
        );

    }
}
