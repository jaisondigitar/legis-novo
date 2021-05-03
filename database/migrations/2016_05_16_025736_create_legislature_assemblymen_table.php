<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatelegislatureAssemblymenTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legislature_assemblymen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legislature_id');
            $table->integer('assemblyman_id');
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
        Schema::drop('legislature_assemblymen');
    }
}
