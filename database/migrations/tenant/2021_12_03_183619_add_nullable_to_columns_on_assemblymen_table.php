<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToColumnsOnAssemblymenTable extends Migration
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
            $table->string('full_name')->nullable()->change();
            $table->string('phone1')->nullable()->change();
            $table->string('general_register')->nullable()->change();
            $table->integer('companies_id')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->string('official_document')->nullable()->change();
            $table->string('street')->nullable()->change();
            $table->string('number')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->integer('state_id')->nullable()->change();
            $table->integer('city_id')->nullable()->change();
            $table->string('zipcode')->nullable()->change();
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
            $table->string('complement')->change();
            $table->string('phone2')->change();
            $table->string('full_name')->change();
            $table->string('phone1')->change();
            $table->string('general_register')->change();
            $table->integer('companies_id')->change();
            $table->string('image')->change();
            $table->string('official_document')->change();
            $table->string('street')->change();
            $table->string('number')->change();
            $table->string('district')->change();
            $table->integer('state_id')->change();
            $table->integer('city_id')->change();
            $table->string('zipcode')->change();
        });
    }
}
