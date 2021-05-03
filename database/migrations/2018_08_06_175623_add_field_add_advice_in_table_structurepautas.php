<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAddAdviceInTableStructurepautas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->boolean('add_advice')->default(0)->after('add_ass');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structurepautas', function (Blueprint $table) {
            $table->dropColumn('add_advice');

        });
    }
}
