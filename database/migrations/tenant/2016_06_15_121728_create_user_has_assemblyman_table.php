<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserHasAssemblymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('user_assemblyman')) {
            Schema::create('user_assemblyman', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('users_id');
                $table->integer('assemblyman_id');
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
        Schema::drop('user_assemblyman');
    }
}
