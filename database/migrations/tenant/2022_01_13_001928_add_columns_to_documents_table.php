<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDocumentsTable extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('original_file')->nullable();
            $table->string('with_attachments_file')->nullable();
            $table->string('signed_file')->nullable();
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('original_file');
            $table->dropColumn('with_attachments_file');
            $table->dropColumn('signed_file');
        });
    }
}
