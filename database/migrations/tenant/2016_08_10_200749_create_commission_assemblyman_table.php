<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionAssemblymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('commission_assemblyman')) {
            Schema::create('commission_assemblyman', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('commission_id')->unsigned();
                $table->integer('assemblyman_id')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('commission_assemblyman');
    }
}
