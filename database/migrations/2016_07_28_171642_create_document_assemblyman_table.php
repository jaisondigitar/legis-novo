<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentAssemblymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('document_assemblyman')) {
            Schema::create('document_assemblyman', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('document_id')->unsigned();
                $table->integer('assemblyman_id')->unsigned();
                $table->timestamps();
            });
        }

        Schema::table('document_assemblyman', function($table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('assemblyman_id')->references('id')->on('assemblymen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_assemblyman');
    }
}
