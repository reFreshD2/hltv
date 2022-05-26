<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class ChampionshipMatchDTO
{
    /**
     * @JMS\Type("string")
     * @var string
     */
    private $matchId;

    /**
     * @JMS\Type("string")
     * @var string
     */
    private $competitionName;

    public function getMatchId(): string
    {
        return $this->matchId;
    }

    public function getCompetitionName(): string
    {
        return $this->competitionName;
    }
}