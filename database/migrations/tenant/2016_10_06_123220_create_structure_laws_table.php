<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStructureLawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_laws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('law_id');
            $table->integer('law_structure_id');
            $table->integer('order');
            $table->integer('number');
            $table->text('content');
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
        Schema::drop('structure_laws');
    }
}
