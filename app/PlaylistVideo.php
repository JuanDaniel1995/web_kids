<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
	protected $table='playlist_video';
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
