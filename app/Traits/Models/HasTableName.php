<?php

namespace App\Traits\Models;

use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait HasTableName
{
    /**
     * Get the full name of the table.
     *
     * @return string
     */
    public static function tableFullName(): string
    {
        return (new static())->getTable();
    }

    /**
     * Get the singular name of the table.
     *
     * @return string
     */
    public static function singularTableFullName(): string
    {
        return Str::singular(self::tableFullName());
    }

    /**
     * Get the plural name of the table.
     *
     * @return string
     */
    public static function pluralTableFullName(): string
    {
        return Str::plural(self::tableFullName());
    }
}
