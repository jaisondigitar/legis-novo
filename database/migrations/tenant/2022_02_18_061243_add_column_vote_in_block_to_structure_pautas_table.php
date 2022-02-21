<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnVoteInBlockToStructurePautasTable extends Migration
{
    public function up()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->boolean('vote_in_block')->nullable()->default(false);
        });
    }

    public function down()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->dropColumn('vote_in_block');
        });
    }
}
