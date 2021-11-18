<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatedocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('documents')) {
            Schema::create('documents', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('document_type_id')->unsigned();
                $table->integer('users_id')->unsigned();
                $table->integer('owner_id')->unsigned();
                $table->string('number');
                $table->text('content');
                $table->date('session_date');
                $table->boolean('read');
                $table->boolean('approved');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('users_id')->references('id')->on('users');
                $table->foreign('owner_id')->references('id')->on('assemblymen');
                $table->foreign('document_type_id')->references('id')->on('document_types');
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
        Schema::drop('documents');
    }
}
