<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeetingPauta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_pauta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id');
            $table->integer('structure_id');
            $table->integer('law_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('meeting_pauta');
    }
}
