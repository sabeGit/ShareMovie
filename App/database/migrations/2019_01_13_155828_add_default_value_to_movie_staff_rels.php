<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultValueToMovieStaffRels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_staff_rels', function (Blueprint $table) {
            $table->boolean('is_actor')->default(0)->change();
			$table->boolean('is_crew')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_staff_rels', function (Blueprint $table) {
            $table->boolean('is_actor')->change();
            $table->boolean('is_crew')->change();
        });
    }
}
