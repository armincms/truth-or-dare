<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODAddStageToGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tod_games', function (Blueprint $table) { 
            $table->integer('stage')->default(1); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tod_games', function (Blueprint $table) { 
            $table->dropColumn('stage'); 
        });
    }
}
