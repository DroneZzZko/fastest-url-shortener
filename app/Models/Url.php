<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $url
 * @property string $created_at
 *
 * @method static self find(int $id)
 */
class Url extends Model
{
    protected $table = "urls";

    protected static function booted(): void
    {
        static::addGlobalScope('expired', static function (Builder $builder) {
            $lifetime = config('short_url')['lifetime'];
            $builder->whereRaw("DATE_ADD(created_at, INTERVAL {$lifetime} SECOND) >= NOW()");
        });

    }
}
