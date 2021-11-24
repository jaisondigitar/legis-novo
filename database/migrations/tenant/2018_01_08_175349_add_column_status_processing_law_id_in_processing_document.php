<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnStatusProcessingLawIdInProcessingDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('processing_documents', function (Blueprint $table) {
            $table->integer('status_processing_document_id')->after('document_situation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processing_documents', function (Blueprint $table) {
            $table->dropColumn('status_processing_document_id');
        });
    }
}
