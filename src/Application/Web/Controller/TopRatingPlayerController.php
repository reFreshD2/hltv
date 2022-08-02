<?php

declare(strict_types=1);

namespace App\Application\Web\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TopRatingPlayerController extends AbstractController
{
    /**
     * @var PlayerRepository
     */
    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(): Response
    {
        $players = $this->playerRepository->findAll();
        usort($players, function (Player $player1, Player $player2) {
            if ($player1->getRating() === $player2->getRating()) {
                return 0;
            }

            return $player1->getRating() > $player2->getRating() ? -1 : 1;
        });

        return $this->render('web/top/top.html.twig', [
            'players' => $players,
        ]);
    }
}
