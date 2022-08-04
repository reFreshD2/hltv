<?php

declare(strict_types=1);

namespace App\Infrastructure\Faceit\ResponseDTO;

use JMS\Serializer\Annotation as JMS;

class PlayerStatsDTO
{
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Headshots")
     */
    private int $headshots;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Deaths")
     */
    private int $deaths;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Triple Kills")
     */
    private int $tripleKills;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Assists")
     */
    private int $assists;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Kills")
     */
    private int $kills;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Penta Kills")
     */
    private int $pentaKills;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("MVPs")
     */
    private int $mvp;
    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("Quadro Kills")
     */
    private int $quadroKills;

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
