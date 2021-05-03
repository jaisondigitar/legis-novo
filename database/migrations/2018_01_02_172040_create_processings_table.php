<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('law_projects_id');
            $table->integer('advice_publication_id')->nullable();
            $table->integer('advice_situation_id');
            $table->date('processing_date')->nullable();
            $table->string('processing_file')->default('')->nullable();
            $table->text('obsevation')->nullable();
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
        Schema::drop('processings');
    }
}
