<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatelawsProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laws_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('law_type_id');
            $table->integer('law_place_id');
            $table->datetime('law_date');
            $table->datetime('law_date_publish');
            $table->integer('law_number');
            $table->integer('project_number');
            $table->string('title');
            $table->string('sub_title');
            $table->integer('assemblyman_id');
            $table->boolean('is_ready');
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
        Schema::drop('laws_projects');
    }
}
