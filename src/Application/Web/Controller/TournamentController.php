<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use App\Domain\Statistic\StatisticService;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TournamentController extends AbstractController
{
    private TournamentRepository $tournamentRepository;
    private StatisticService $statisticService;

    public function __construct(TournamentRepository $tournamentRepository, StatisticService $statisticService)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->statisticService = $statisticService;
    }

    public function __invoke(): Response
    {
        $tournaments = array_reverse($this->tournamentRepository->findAll());
        $countTeams = [];
        foreach ($tournaments as $tournament) {
            $countTeams[] = $tournament->getTeams()->count();
        }

        return $this->render(
            'web/tournament/tournament.html.twig',
            [
                'tournaments' => $tournaments,
                'countTeam' => $countTeams,
            ]
        );
    }

    public function getTournamentView(Request $request, string $id): Response
    {
        $tab = $request->query->get('tab');
        $tournament = $this->tournamentRepository->findOneBy(['id' => $id]);

        switch ($tab) {
            case 'matches':
                return $this->render(
                    'web/tournament/tournament-view-matches.html.twig',
                    ['tournament' => $tournament]
                );
            case 'stats':
                return $this->render(
                    'web/tournament/tournament-view-stats.html.twig',
                    [
                        'tournament' => $tournament,
                        'topPlayers' => $this->statisticService->getTournamentTopPlayer($tournament),
                    ]
                );
            default:
                return $this->render(
                    'web/tournament/tournament-view-index.html.twig',
                    ['tournament' => $tournament]
                );
        }
    }
}
