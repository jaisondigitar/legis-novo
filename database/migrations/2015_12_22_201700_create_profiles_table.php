<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('image');
			$table->string('fullName');
			$table->text('about');
			$table->string('facebook');
			$table->string('twitter');
			$table->string('linkedin');
			$table->string('instagram');
			$table->integer('city');
			$table->integer('state');
			$table->boolean('active');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profiles');
	}

}
