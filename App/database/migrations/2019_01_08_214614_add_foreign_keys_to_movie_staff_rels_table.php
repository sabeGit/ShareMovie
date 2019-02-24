<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMovieStaffRelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movie_staff_rels', function(Blueprint $table)
		{
			$table->foreign('movie_id')->references('id')->on('movies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('staff_id')->references('id')->on('staffs')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movie_staff_rels', function(Blueprint $table)
		{
			$table->dropForeign('movie_staff_rels_movie_id_foreign');
			$table->dropForeign('movie_staff_rels_staff_id_foreign');
		});
	}

}
