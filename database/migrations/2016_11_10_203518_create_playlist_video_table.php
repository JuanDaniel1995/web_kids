<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_video', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('playlist_id')->unsigned();
            $table->foreign('playlist_id')->references('id')->on('playlists');
            $table->integer('video_id')->unsigned();
            $table->foreign('video_id')->references('id')->on('videos');
            $table->unique(array('playlist_id', 'video_id'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('playlist_video');
    }
}
