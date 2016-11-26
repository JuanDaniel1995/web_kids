<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'user_id', 'public', 'youtube_id',
    ];
}
