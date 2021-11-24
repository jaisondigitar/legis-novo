<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf');
            $table->string('rg')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('celular');
            $table->string('zipcode');
            $table->string('street')->nullable();
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('district')->nullable();
            $table->string('state_id');
            $table->string('city_id');
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
        Schema::drop('people');
    }
}
