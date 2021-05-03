<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtaMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("meetings", function(Blueprint $table){
            $table->longText('ata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *php ar
     * @return void
     */
    public function down()
    {
        Schema::table("meetings", function(Blueprint $table){
            $table->dropColumn('ata');
        });
    }
}
