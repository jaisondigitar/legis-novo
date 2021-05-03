<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextToLaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('laws_projects', function (Blueprint $table) {
             $table->text('justify')->default('');
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
             $table->dropColumn('justify');
         });
     }
}
