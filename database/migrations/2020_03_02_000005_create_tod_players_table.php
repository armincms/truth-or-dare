<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_players', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('name'); 
            $table->enum('gender', Common::genders()->keys()->all())->default('male');
            $table->enum('age', Common::ages()->keys()->all())->default('adult');
            $table->enum('marital', Common::maritals()->keys()->all())->default('single');  
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
        Schema::dropIfExists('tod_players');
    }
}
