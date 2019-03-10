<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFavoriteAndwatchedDefaultValueMovieUserRels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_user_rels', function (Blueprint $table) {
            $table->dropColumn('favorite');
            $table->dropColumn('watched');
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
            $table->boolean('favorite');
            $table->boolean('watched');
        });
    }
}
