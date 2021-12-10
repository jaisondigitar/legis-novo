<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSectorIdToDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->integer('sector_id')->unsigned()->nullable();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('sector_id')->references('id')
                ->on('sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('sector_id');
            $table->dropColumn('sector_id');
        });
    }
}
