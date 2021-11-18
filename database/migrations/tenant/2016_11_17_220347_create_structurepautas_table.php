<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStructurepautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structurepautas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            $table->string('name', 255);
            $table->integer('order')->default(0);
            $table->boolean('add_doc')->default(0);
            $table->boolean('add_law')->default(0);
            $table->boolean('add_obs')->default(0);
            $table->boolean('add_ass')->default(0);

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
        Schema::drop('structurepautas');
    }
}
