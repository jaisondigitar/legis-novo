<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToColumnsOnPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('zipcode')->nullable()->change();
            $table->string('number')->nullable()->change();
            $table->string('state_id')->nullable()->change();
            $table->string('city_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('zipcode')->change();
            $table->string('number')->change();
            $table->string('state_id')->change();
            $table->string('city_id')->change();
        });
    }
}
