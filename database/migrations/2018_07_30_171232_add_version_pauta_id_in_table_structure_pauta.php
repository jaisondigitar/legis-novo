<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVersionPautaIdInTableStructurePauta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->integer('version_pauta_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->dropColumn('version_pauta_id');

        });
    }
}
