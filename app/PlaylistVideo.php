<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    //
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'playlist_id', 'video_id',
    ];
}
