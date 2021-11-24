<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSufixLawproject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->text('sufix')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->dropColumn('sufix');
        });
    }
}
