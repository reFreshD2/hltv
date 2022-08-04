<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class RoundStatsDTO
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Map")
     */
    private string $map;
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Score")
     */
    private string $score;

    public function getMap(): string
    {
        return $this->map;
    }

    public function getScore(): string
    {
        return $this->score;
    }
}
