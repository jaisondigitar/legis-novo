<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDocsTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_docs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multi_docs_schedule_id')->references('id')
                ->on('multi_docs_schedule');
            $table->string('model_type');
            $table->integer('model_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_docs');
    }
}
