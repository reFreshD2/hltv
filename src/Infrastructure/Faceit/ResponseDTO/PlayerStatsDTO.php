<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class PlayerStatsDTO
{
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Headshots")
     * @var int
     */
    private $headshots;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Deaths")
     * @var int
     */
    private $deaths;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Triple Kills")
     * @var int
     */
    private $tripleKills;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Assists")
     * @var int
     */
    private $assists;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Kills")
     * @var int
     */
    private $kills;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Penta Kills")
     * @var int
     */
    private $pentaKills;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("MVPs")
     * @var int
     */
    private $mvp;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Quadro Kills")
     * @var int
     */
    private $quadroKills;

    public function getAssists(): int
    {
        return $this->assists;
    }

    public function getDeaths(): int
    {
        return $this->deaths;
    }

    public function getHeadshots(): int
    {
        return $this->headshots;
    }

    public function getKills(): int
    {
        return $this->kills;
    }

    public function getMvp(): int
    {
        return $this->mvp;
    }

    public function getPentaKills(): int
    {
        return $this->pentaKills;
    }

    public function getQuadroKills(): int
    {
        return $this->quadroKills;
    }

    public function getTripleKills(): int
    {
        return $this->tripleKills;
    }
}
