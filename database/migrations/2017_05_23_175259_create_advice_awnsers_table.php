<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateadviceAwnsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advice_awnsers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advice_id');
            $table->integer('commission_id');
            $table->date('date');
            $table->text('description');
            $table->string('file')->nullable();
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
        Schema::drop('advice_awnsers');
    }
}
