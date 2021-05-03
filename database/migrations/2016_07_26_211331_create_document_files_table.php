<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('document_files')) {
            Schema::create('document_files', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('document_id')->unsigned();
                $table->string('filename');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('document_id')->references('id')->on('documents');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_files');
    }
}
