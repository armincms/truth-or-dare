<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_stages', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->boolean('passed')->default(0); 
            $table->unsignedInteger('stage')->default(0); 
            $table->unsignedBigInteger('player_id'); 
            $table->unsignedBigInteger('game_id'); 
            $table->unsignedBigInteger('question_id')->nullable(); 
            $table->unsignedBigInteger('consequence_id')->nullable(); 
            $table->timestamps();     
            $table->softDeletes();

            $table->foreign('player_id')->references('id')->on('tod_players')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('game_id')->references('id')->on('tod_games')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('question_id')->references('id')->on('tod_questions')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('consequence_id')->references('id')->on('tod_consequences')
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
        Schema::dropIfExists('tod_stages');
    }
}
