<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProcessingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processing_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->integer('document_situation_id');
            $table->date('processing_document_date')->nullable();
            $table->string('processing_document_file')->default('')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('processing_documents');
    }
}
