<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_games', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('game'); 
            $table->enum('level', Common::levels()->keys()->all())->default('normal');
            $table->auth();
            $table->timestamps();     
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tod_games');
    }
}
