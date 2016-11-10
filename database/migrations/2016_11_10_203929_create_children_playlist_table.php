<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenPlaylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children_playlist', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('children_id')->unsigned();
            $table->foreign('children_id')->references('id')->on('childrens');
            $table->integer('playlist_id')->unsigned();
            $table->foreign('playlist_id')->references('id')->on('playlists');
            $table->unique(array('children_id', 'playlist_id'));
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
        Schema::drop('children_playlist');
    }
}
