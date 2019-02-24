<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMovieStaffRelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movie_staff_rels', function(Blueprint $table)
		{
			$table->integer('movie_id')->unsigned();
			$table->integer('staff_id')->unsigned()->index('movie_staff_rels_staff_id_foreign');
			$table->timestamps();
			$table->boolean('is_actor');
			$table->boolean('is_crew');
			$table->unique(['movie_id','staff_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movie_staff_rels');
	}

}
