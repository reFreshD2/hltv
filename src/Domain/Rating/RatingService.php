<?php

declare(strict_types=1);

namespace App\Domain\Rating;

use App\Entity\Stats;

class RatingService
{
    private const BASE_RATING_DIFF = 20;
    private const BASE_PLAYER_IMPACT = 10;
    private const TEAM_RATING_DIFF = [
        0 =>  1,
        50 => 0.8,
        150 =>  0.6,
        250 =>  0.4,
        350 =>  0.2,
    ];

    public function calculateRatingDiff(bool $isWin, Stats $stats, float $avgTeamRatingDiff, int $winRounds): float
    {
        $kda = (($stats->getKills() + $stats->getAssists()) / $stats->getDeaths());
        if ($this->detectNeg($kda)) {
            $kda *= -1;
        }

        $baseRating = $isWin ? (self::BASE_RATING_DIFF * $kda) : (self::BASE_RATING_DIFF / $kda);

        $isNegDiff = $this->detectNeg($avgTeamRatingDiff);
        if ($isNegDiff) {
            $avgTeamRatingDiff *= -1;
        }

        $lastMultipliers = null;
        $ratingDiffMultiplier = null;
        foreach (self::TEAM_RATING_DIFF as $diff => $multipliers) {
            if ($avgTeamRatingDiff >= $diff) {
                $lastMultipliers = $multipliers;
                continue;
            }

            $ratingDiffMultiplier = $lastMultipliers;
            break;
        }

        if ($ratingDiffMultiplier === null) {
            $teamRatingDiff = self::TEAM_RATING_DIFF;
            $ratingDiffMultiplier = array_pop($teamRatingDiff);
        }

        return $isWin
            ? ($baseRating * $ratingDiffMultiplier + $this->getPlayerImpact($stats, $winRounds))
            : ($baseRating / $ratingDiffMultiplier * -1 + $this->getPlayerImpact($stats, $winRounds));
    }

    private function detectNeg(float $float): bool
    {
        return $float < 0;
    }

    private function getPlayerImpact(Stats $stats, int $winRounds): float
    {
        return self::BASE_PLAYER_IMPACT * ($stats->getMvp() / $winRounds);
    }
}
