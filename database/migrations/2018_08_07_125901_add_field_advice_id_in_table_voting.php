<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAdviceIdInTableVoting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votings', function (Blueprint $table) {
            $table->integer('advice_id')->nullable()->after('ata_id');
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
            $table->dropColumn('advice_id');

        });
    }
}
