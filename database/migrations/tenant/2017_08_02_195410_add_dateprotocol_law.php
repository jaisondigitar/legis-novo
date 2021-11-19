<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDateprotocolLaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laws_projects', function (Blueprint $table) {
            $table->date('protocoldate')->default('0000-00-00 00:00:00')->after('protocol');
            $table->longText('sufix')->default('')->nullable()->change();
            $table->longText('justify')->default('')->nullable()->change();
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
            $table->dropColumn('protocoldate');
            $table->text('sufix')->default('')->nullable()->change();
            $table->text('justify')->default('')->nullable()->change();
        });
    }
}
