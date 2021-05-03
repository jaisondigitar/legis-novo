<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusProcessingLawIdInProcessing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processings', function (Blueprint $table) {
            $table->integer('status_processing_law_id')->after('advice_situation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processings', function (Blueprint $table) {
            $table->dropColumn('status_processing_law_id');
        });
    }
}
