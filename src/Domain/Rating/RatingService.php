<?php

declare(strict_types=1);

namespace App\Domain\Rating;

use App\Entity\Stats;

class RatingService
{
    private const BASE_RATING_DIFF = 20;
    private const TEAM_RATING_DIFF = [
        0 => [
            'less' => 1,
            'more' => 1,
        ],
        50 => [
            'less' => 0.75,
            'more' => 1.25,
        ],
        150 => [
            'less' => 0.5,
            'more' => 1.5,
        ],
        250 => [
            'less' => 0.25,
            'more' => 1.75,
        ],
        350 => [
            'less' => 0.1,
            'more' => 2,
        ],
    ];

    public function calculateRatingDiff(bool $isWin, Stats $stats, float $avgTeamRatingDiff): float
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
            if ($avgTeamRatingDiff > $diff) {
                $lastMultipliers = $multipliers;
                continue;
            }

            $ratingDiffMultiplier = ($isWin xor $isNegDiff) ? $lastMultipliers['less'] : $lastMultipliers['more'];
            break;
        }

        if ($ratingDiffMultiplier !== null) {
            $teamRatingDiff = self::TEAM_RATING_DIFF;
            $multipliers = array_pop($teamRatingDiff);
            $ratingDiffMultiplier = ($isWin xor $isNegDiff) ? $multipliers['less'] : $multipliers['more'];
        }

        return $isWin ? ($baseRating * $ratingDiffMultiplier) : ($baseRating / $ratingDiffMultiplier * -1);
    }

    private function detectNeg(float $float): bool
    {
        return $float < 0;
    }
}
