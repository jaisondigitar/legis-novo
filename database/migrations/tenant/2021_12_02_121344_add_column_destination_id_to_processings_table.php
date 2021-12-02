<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDestinationIdToProcessingsTable extends Migration
{
    public function up()
    {
        Schema::table('processings', function (Blueprint $table) {
            $table->integer('destination_id')->unsigned()->nullable();
        });

        Schema::table('processings', function (Blueprint $table) {
            $table->foreign('destination_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('processings', function (Blueprint $table) {
            $table->dropForeign('destination_id');
            $table->dropColumn('destination_id');
        });
    }
}
