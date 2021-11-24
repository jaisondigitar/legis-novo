<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterTypeColumnObservationInLawProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->longText('observation')->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->string('observation')->default('')->change();
        });
    }
}
