<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAdviceIdInTableMeetingPauta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meeting_pauta', function (Blueprint $table) {
            $table->integer('advice_id')->nullable()->after('document_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meeting_pauta', function (Blueprint $table) {
            $table->dropColumn('advice_id');

        });
    }
}
