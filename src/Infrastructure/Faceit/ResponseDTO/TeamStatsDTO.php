<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class TeamStatsDTO
{
    /**
     * @JMS\SerializedName("Team")
     * @JMS\Type("string")
     * @var string
     */
    private $teamName;

    public function getTeamName(): string
    {
        return $this->teamName;
    }
}