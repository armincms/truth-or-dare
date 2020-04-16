<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODConsequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
        Schema::create('tod_consequences', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('consequence', 500);    
            $table->boolean('punishment')->default(true); 

            $table->set('gender', Common::genders()->keys()->all())->nullable();
            $table->set('marital', Common::maritals()->keys()->all())->nullable();
            $table->set('age', Common::ages()->keys()->all())->nullable(); 
            $table->set('level', Common::levels()->keys()->all())->nullable();

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
        Schema::dropIfExists('tod_consequences');
    }
}
