<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiDocsScheduleTable extends Migration
{
    public function up()
    {
        Schema::create('multi_docs_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('meeting_id')->references('id')->on('meetings');
            $table->unsignedInteger('structure_id')->references('id')
                ->on('structurepautas');
            $table->text('description')->nullable();
            $table->text('observation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multi_docs_schedule');
    }
}
