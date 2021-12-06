<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDestinationIdToProcessingDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('processing_documents', function (Blueprint $table) {
            $table->bigInteger('destination_id')->unsigned()->nullable();
        });

        Schema::table('processing_documents', function (Blueprint $table) {
            $table->foreign('destination_id')->references('id')
                ->on('destinations');
        });
    }

    public function down()
    {
        Schema::table('processing_documents', function (Blueprint $table) {
            $table->dropForeign('destination_id');
            $table->dropColumn('destination_id');
        });
    }
}
