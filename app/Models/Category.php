<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Uuid;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'uuid',
    ];
}
