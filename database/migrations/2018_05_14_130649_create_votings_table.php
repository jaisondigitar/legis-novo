<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id');
            $table->integer('type_voting_id')->nullable();
            $table->dateTime('open_at');
            $table->integer('assemblyman_active')->nullable();
            $table->integer('law_id')->nullable();
            $table->integer('document_id')->nullable();
            $table->dateTime('closed_at')->nullable();
            $table->softDeletes();
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
        Schema::drop('votings');
    }
}
