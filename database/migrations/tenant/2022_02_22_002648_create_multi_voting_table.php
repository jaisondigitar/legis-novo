<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiVotingTable extends Migration
{
    public function up()
    {
        Schema::create('multi_voting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multi_docs_schedule_id')->references('id')
                ->on('multi_docs_schedule');
            $table->timestamp('closed_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('multi_voting');
    }
}
