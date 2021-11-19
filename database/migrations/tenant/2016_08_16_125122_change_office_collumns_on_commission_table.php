<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeOfficeCollumnsOnCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_assemblyman', function (Blueprint $table) {
            $table->integer('office')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            $table->string('office')->change();
        });
    }
}
