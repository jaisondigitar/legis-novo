<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefixToLawstructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //laws_structures
        Schema::table('laws_structures', function (Blueprint $table) {
            $table->string('prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laws_structures', function (Blueprint $table) {
            $table->dropColumn('prefix');
        });
    }
}
