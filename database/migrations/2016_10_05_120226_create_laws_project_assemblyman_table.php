<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLawsProjectAssemblymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_project_assemblyman', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('law_project_id');
            $table->integer('assemblyman_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('law_project_assemblyman');
    }
}
