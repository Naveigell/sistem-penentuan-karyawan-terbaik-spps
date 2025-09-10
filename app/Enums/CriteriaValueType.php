<?php

namespace App\Enums;

use App\Enums\Interfaces\HasHtmlBadge;
use App\Enums\Interfaces\HasLabel;
use App\Enums\Interfaces\Randomable;

enum CriteriaValueType: string implements Randomable, HasLabel, HasHtmlBadge
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

    /**
     * Retrieves the label associated with the object.
     *
     * @return string The label.
     */
    public function label()
    {
        return match ($this) {
            self::NOMINAL => 'Nominal',
            self::RANGE => 'Range',
            self::OPTION => 'Option',
        };
    }


    /**
     * Converts the object to an HTML badge.
     *
     * @return string The HTML representation of the badge.
     */
    public function toHtmlBadge()
    {
        return match ($this) {
            self::NOMINAL => '<span class="badge badge-primary">' . $this->label() . '</span>',
            self::RANGE => '<span class="badge badge-success">' . $this->label() . '</span>',
            self::OPTION => '<span class="badge badge-warning">' . $this->label() . '</span>',
        };
    }
}
