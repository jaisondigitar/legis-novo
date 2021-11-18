<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateassemblymenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblymen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('companies_id');
            $table->string('image');
            $table->string('short_name');
            $table->string('full_name');
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('official_document');
            $table->string('general_register');
            $table->string('street');
            $table->string('number');
            $table->string('complement');
            $table->string('district');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->string('zipcode');
            $table->boolean('active');
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
        Schema::drop('assemblymen');
    }
}
