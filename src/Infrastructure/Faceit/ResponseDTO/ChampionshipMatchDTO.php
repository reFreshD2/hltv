<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class ChampionshipMatchDTO
{
    /**
     * @JMS\Type("string")
     */
    private string $matchId;
    /**
     * @JMS\Type("string")
     */
    private string $competitionName;

    public function getMatchId(): string
    {
        return $this->matchId;
    }

    public function getCompetitionName(): string
    {
        return $this->competitionName;
    }
}
