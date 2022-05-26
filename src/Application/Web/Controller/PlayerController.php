<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use App\Domain\Statistic\StatisticService;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractController
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;
    /**
     * @var StatisticService
     */
    private $statisticService;

    public function __construct(PlayerRepository $playerRepository, StatisticService $statisticService)
    {
        $this->playerRepository = $playerRepository;
        $this->statisticService = $statisticService;
    }

    public function __invoke(string $id): Response
    {
        $player = $this->playerRepository->findOneBy(['id' => $id]);
        if (!$player) {
            return $this->render('404.html.twig');
        }
        $playerStatistic = $this->statisticService->getPlayerStats($player);
        $games = [];
        foreach ($player->getStats() as $stat) {
            $games[] = $stat->getGame();
        }

        return $this->render('web/player/player-view-page.html.twig', [
            'playerStat' => $playerStatistic,
            'games' => $games,
        ]);
    }
}