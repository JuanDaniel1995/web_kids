<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildrenPlaylist extends Model
{

    protected $table = 'children_playlist';

    protected $fillable = [
        'playlist_id', 'children_id',
    ];
}
