<?php

namespace App\Enums\Interfaces;

interface HasLabel
{
    /**
     * Retrieves the label associated with the object.
     *
     * @return string The label.
     */
    public function label();
}
