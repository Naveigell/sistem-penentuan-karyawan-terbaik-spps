<?php

namespace App\Enums\Interfaces;

interface Randomable
{
    /**
     * Returns a random case from the current enum.
     *
     * @return array|string|int|self
     */
    public static function random(): array|string|int|self;
}
