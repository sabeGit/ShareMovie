<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameMovieUserRel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_user_rels', function (Blueprint $table) {
            $table->renameColumn('latest_rating', 'rating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movie_user_rels', function (Blueprint $table) {
            $table->renameColumn('rating', 'latest_rating');
        });
    }
}
