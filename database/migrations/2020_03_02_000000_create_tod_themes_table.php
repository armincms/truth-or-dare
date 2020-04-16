<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTODThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_themes', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('label', 100);
            $table->boolean('default')->default(false);
            $table->integer('point')->default(1);
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
        Schema::dropIfExists('tod_themes');
    }
}
