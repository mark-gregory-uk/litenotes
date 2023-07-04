<?php

namespace App\Models;

use App\Models\Traits\Achievable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Note extends Model
{
    use SoftDeletes;
    use Achievable;

    protected $casts = [
        'text' => PurifyHtmlOnGet::class,
        'title' => PurifyHtmlOnGet::class,
    ];

    protected $guarded = [];

    /**
     * return the ID when we need it
     * @return string
     */
    final public function getRouteKeyName() : string
    {
        return 'id';
    }

    /**
     * The user whom owns this note
     * @return BelongsTo
     */
    final public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
