<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODGamePlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_game_player', function (Blueprint $table) {
            $table->bigIncrements('id');   
            $table->unsignedBigInteger('player_id'); 
            $table->unsignedBigInteger('game_id');  

            $table->foreign('player_id')->references('id')->on('tod_players')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('game_id')->references('id')->on('tod_games')
                  ->onDelete('cascade')
                  ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tod_game_player');
    }
}
