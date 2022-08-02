<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class RoundStatsDTO
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Map")
     * @var string
     */
    private $map;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Score")
     * @var string
     */
    private $score;

    public function getMap(): string
    {
        return $this->map;
    }

    public function getScore(): string
    {
        return $this->score;
    }
}
