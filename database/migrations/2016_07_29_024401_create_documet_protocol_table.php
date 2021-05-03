<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumetProtocolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('document_protocol')) {
            Schema::create('document_protocol', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('document_id')->unsigned();
                $table->integer('protocol_type_id')->unsigned();
                $table->string('number');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        Schema::table('document_protocol', function($table) {
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('protocol_type_id')->references('id')->on('protocol_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('document_protocol');
    }
}
