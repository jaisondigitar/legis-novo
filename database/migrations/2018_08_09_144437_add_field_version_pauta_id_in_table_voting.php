<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldVersionPautaIdInTableVoting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votings', function (Blueprint $table) {

            $table->integer('version_pauta_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votings', function (Blueprint $table) {
            $table->dropColumn('version_pauta_id');

        });
    }
}
