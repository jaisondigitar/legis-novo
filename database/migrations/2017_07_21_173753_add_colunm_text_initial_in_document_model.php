<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunmTextInitialInDocumentModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_models', function (Blueprint $table) {
            $table->text('text_initial')->default('')->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_models', function (Blueprint $table) {
            $table->dropColumn('text_initial');
        });
    }
}
