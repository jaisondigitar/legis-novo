<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMeetingFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('meeting_files')) {
            Schema::create('meeting_files', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('meeting_id')->unsigned();
                $table->string('filename');
                $table->timestamps();
                $table->softDeletes();
                $table->foreign('meeting_id')->references('id')->on('meetings');
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
        Schema::drop('meeting_files');
    }
}

