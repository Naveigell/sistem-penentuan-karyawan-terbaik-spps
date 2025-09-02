<?php

namespace App\Utils\DecisionSupportSystem\Enums;

use App\Enums\Interfaces\Randomable;

enum CriteriaType: string implements Randomable
{
    case BENEFIT = 'benefit';

    case COST = 'cost';


    /**
     * Check if the current criteria type is a benefit type.
     *
     * @return bool True if the current criteria type is a benefit type, false otherwise.
     */
    public function isBenefit(): bool
    {
        return $this === self::BENEFIT;
    }

    /**
     * Check if the current criteria type is a cost type.
     *
     * @return bool True if the current criteria type is a cost type, false otherwise.
     */
    public function isCost(): bool
    {
        return $this === self::COST;
    }

    /**
     * Returns a random case from the current enum.
     *
     * @return array|string|int|self
     */
    public static function random(): array|string|int|self
    {
        return self::cases()[array_rand(self::cases())];
    }
}
