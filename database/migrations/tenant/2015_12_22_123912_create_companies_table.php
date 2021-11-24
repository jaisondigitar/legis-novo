<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('shortName');
            $table->string('fullName');
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('mayor');
            $table->string('cnpjCpf');
            $table->string('ieRg');
            $table->string('im');
            $table->integer('city');
            $table->integer('state');
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
        Schema::drop('companies');
    }
}
