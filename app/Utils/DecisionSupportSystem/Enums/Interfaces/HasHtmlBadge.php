<?php

namespace App\Enums\Interfaces;

interface HasHtmlBadge
{
    /**
     * Converts the object to an HTML badge.
     *
     * @return string The HTML representation of the badge.
     */
    public function toHtmlBadge();
}
