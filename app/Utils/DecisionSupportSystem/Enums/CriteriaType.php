<?php

namespace App\Utils\DecisionSupportSystem\Enums;

use App\Enums\Interfaces\HasHtmlBadge;
use App\Enums\Interfaces\HasLabel;
use App\Enums\Interfaces\Randomable;

enum CriteriaType: string implements Randomable, HasLabel, HasHtmlBadge
{
    case BENEFIT = 'benefit';

    case COST = 'cost';

    case NO_TYPE = 'no_type';

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
     * Checks if the current criteria type is 'no_type'.
     *
     * This method is used to check if the current criteria type is 'no_type'.
     * It returns true if the current criteria type is 'no_type', false otherwise.
     *
     * @return bool True if the current criteria type is 'no_type', false otherwise.
     */
    public function isNoType(): bool
    {
        return $this === self::NO_TYPE;
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

    /**
     * Retrieves the label associated with the object.
     *
     * @return string The label.
     */
    public function label()
    {
        return match ($this) {
            self::BENEFIT => 'Benefit',
            self::COST    => 'Cost',
            self::NO_TYPE => 'No Type',
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
            self::BENEFIT => '<span class="badge badge-success">' . $this->label() . '</span>',
            self::COST    => '<span class="badge badge-danger">' . $this->label() . '</span>',
            self::NO_TYPE => '<span class="badge badge-secondary">' . $this->label() . '</span>',
        };
    }

    /**
     * Checks if the given value is in the cases of the current enum.
     *
     * If the given value is a string, it will be converted to a CriteriaType using the tryFrom method.
     * If the conversion fails, the method will return false.
     *
     * @param CriteriaType|string $value The value to check.
     *
     * @return bool True if the value is in the cases of the current enum, false otherwise.
     */
    public static function isInCases(CriteriaType|string $value)
    {
        $type = $value;

        if (is_string($value)) {
            $type = CriteriaType::tryFrom($value);

            if (!$type) return false;
        }

        return in_array($type, self::cases());
    }

    /**
     * Returns an array of the values of all the cases in the current enum.
     *
     * @return array An array of the values of all the cases in the current enum.
     */
    public static function values()
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
