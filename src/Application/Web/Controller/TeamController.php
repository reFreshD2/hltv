<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use App\Domain\Statistic\DTO\TeamStatsDTO;
use App\Domain\Statistic\StatisticService;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractController
{
    private TeamRepository $teamRepository;
    private StatisticService $statisticService;

    public function __construct(TeamRepository $teamRepository, StatisticService $statisticService)
    {
        $this->teamRepository = $teamRepository;
        $this->statisticService = $statisticService;

    }

    public function __invoke(): Response
    {
        $teams = $this->teamRepository->findAll();
        $teamsStats = [];
        foreach ($teams as $team) {
            $teamsStats[] = $this->statisticService->getTeamStats($team);
        }

        usort(
            $teamsStats,
            function (TeamStatsDTO $statsDTO1, TeamStatsDTO $statsDTO2) {
                return ($statsDTO1->getRating() >= $statsDTO2->getRating() ? -1 : 1);
            }
        );

        return $this->render(
            'web/teams/teams-page.html.twig',
            ['teamsStats' => $teamsStats]
        );
    }

    public function getTeamView(Request $request, string $id): Response
    {
        $team = $this->teamRepository->findOneBy(['id' => $id]);
        $teamStats = $this->statisticService->getTeamStats($team);

        return $this->render(
            'web/teams/team-view-page.html.twig',
            ['teamStats' => $teamStats]
        );
    }
}
