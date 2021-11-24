<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFieldActiveMesaDiretoraInResponsibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responsibilities', function (Blueprint $table) {
            $table->boolean('skip_board')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responsibilities', function (Blueprint $table) {
            $table->dropColumn('skip_board');
        });
    }
}
