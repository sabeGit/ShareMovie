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
			$table->foreign('movie_id')->references('id')->on('movies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
