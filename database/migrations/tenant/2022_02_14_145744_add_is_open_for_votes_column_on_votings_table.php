<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOpenForVotesColumnOnVotingsTable extends Migration
{
    public function up()
    {
        Schema::table('votings', function (Blueprint $table) {
            $table->boolean('is_open_for_voting')->default(false);
        });
    }

    public function down()
    {
        Schema::table('votings', function (Blueprint $table) {
            $table->dropColumn('is_open_for_voting');
        });
    }
}
