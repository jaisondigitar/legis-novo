<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadLaw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::table('laws_projects', function (Blueprint $table) {
             $table->string('law_file')->nullable()->default(null);
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
             $table->dropColumn('law_file');
         });
     }
}
