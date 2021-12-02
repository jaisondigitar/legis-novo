<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsAssemblymen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assemblymen', function (Blueprint $table) {
            $table->string('complement')->nullable()->change();
            $table->string('phone2')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assemblymen', function (Blueprint $table) {
            $table->dropColumn('complement');
            $table->dropColumn('phone2');
        });
    }
}
