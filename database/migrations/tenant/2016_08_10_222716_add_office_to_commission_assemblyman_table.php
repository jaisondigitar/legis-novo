<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOfficeToCommissionAssemblymanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_assemblyman', function (Blueprint $table) {
            $table->string('office');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_assemblyman', function (Blueprint $table) {
            $table->dropColumn('office');
        });
    }
}
