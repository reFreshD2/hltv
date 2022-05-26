<?php

declare(strict_types=1);

namespace App\Application\Web\Admin\Controller;

use App\Domain\Faceit\TournamentService;
use App\Repository\GameRepository;
use App\Repository\StatsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    /**
     * @var TournamentService
     */
    private $tournamentService;
    /**
     * @var GameRepository
     */
    private $matchesRepository;
    /**
     * @var StatsRepository
     */
    private $statsRepository;

    public function __construct(
        TournamentService $tournamentService,
        GameRepository $matchesRepository,
        StatsRepository $statsRepository
    ) {
        $this->tournamentService = $tournamentService;
        $this->matchesRepository = $matchesRepository;
        $this->statsRepository = $statsRepository;
    }

    public function __invoke(Request $request): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function addChampionship(Request $request): Response
    {
        $championshipId = $request->request->get('championship-id');
        $this->tournamentService->addTournament($championshipId);

        return new Response('ok');
    }

    public function getMatches(): Response
    {
        return $this->render('admin/matches.html.twig', [
            'matches' => $this->matchesRepository->findAll(),
        ]);
    }

    public function deleteMatch(string $id): Response
    {
        $match = $this->matchesRepository->findOneBy(['id' => $id]);

        foreach ($match->getStats() as $stat) {
            $this->statsRepository->remove($stat, false);
        }
        $this->matchesRepository->remove($match);

        return $this->redirect('/admin/matches');
    }
}