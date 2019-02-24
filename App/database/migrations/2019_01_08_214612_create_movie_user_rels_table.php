<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovieUserRelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movie_user_rels', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('movie_id')->unsigned()->index('movie_user_rels_movie_id_foreign');
			$table->boolean('is_watched')->default(1);
			$table->boolean('is_want')->default(1);
			$table->integer('latest_rating')->nullable();
			$table->timestamps();
			$table->unique(['user_id','movie_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movie_user_rels');
	}

}
