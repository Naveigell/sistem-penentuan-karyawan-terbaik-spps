<?php

namespace App\Enums;

use App\Enums\Interfaces\Randomable;

enum CriteriaValueType: string implements Randomable
{
    case NOMINAL = 'nominal';

    case RANGE = 'range';

    case OPTION = 'option';

    /**
     * @return bool True if the current criteria type is nominal, false otherwise
     */
    public function isNominal()
    {
        return $this == self::NOMINAL;
    }

    /**
     * @return bool True if the current criteria type is range, false otherwise
     */
    public function isRange()
    {
        return $this == self::RANGE;
    }

    /**
     * @return bool True if the current criteria type is option, false otherwise
     */
    public function isOption()
    {
        return $this == self::OPTION;
    }

    /**
     * Returns a random case from the current enum.
     *
     * @return array|string|int|self|CriteriaValueType
     */
    public static function random(): array|string|int|self|CriteriaValueType
    {
        return self::cases()[array_rand(self::cases())];
    }
}
