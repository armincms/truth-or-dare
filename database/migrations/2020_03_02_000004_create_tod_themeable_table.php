<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTODThemeableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_themeable', function (Blueprint $table) {
            $table->bigIncrements('id');  
            $table->unsignedBigInteger("theme_id");
            $table->morphs("themeable");

            $table->foreign('theme_id')->references("id")->on("tod_themes")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tod_themeable');
    }
}
