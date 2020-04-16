<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Armincms\RawData\Common;

class CreateTODQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tod_questions', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('question', 500);    
            $table->boolean('truth')->default(true);
            $table->unsignedBigInteger('theme_id');

            $table->set('gender', Common::genders()->keys()->all())->nullable();
            $table->set('marital', Common::maritals()->keys()->all())->nullable();
            $table->set('age', Common::ages()->keys()->all())->nullable(); 
            $table->enum('level', Common::levels()->keys()->all())->default('normal');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('theme_id')->references('id')->on('tod_themes')
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
        Schema::dropIfExists('tod_questions');
    }
}
