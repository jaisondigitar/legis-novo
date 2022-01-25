<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_sectors', function (Blueprint $table) {
            $table->id();

            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')->references('id')->on('documents');

            $table->integer('sector_id')->unsigned();
            $table->foreign('sector_id')->references('id')->on('sectors');

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
        Schema::dropIfExists('documents_sectors');
    }
}
