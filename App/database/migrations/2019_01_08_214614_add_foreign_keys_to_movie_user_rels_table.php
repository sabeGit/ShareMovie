<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMovieUserRelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movie_user_rels', function(Blueprint $table)
		{
			$table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movie_user_rels', function(Blueprint $table)
		{
			$table->dropForeign('movie_user_rels_movie_id_foreign');
			$table->dropForeign('movie_user_rels_user_id_foreign');
		});
	}

}
