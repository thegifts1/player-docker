<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = [
        'name',
        'track_name',
        'duration',
        'size',
    ];
}
