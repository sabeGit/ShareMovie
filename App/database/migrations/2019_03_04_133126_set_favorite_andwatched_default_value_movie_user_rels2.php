<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetFavoriteAndwatchedDefaultValueMovieUserRels2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_user_rels', function (Blueprint $table) {
            $table->boolean('favorite')->default(false);
            $table->boolean('watched')->default(false);
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
            $table->dropColumn('favorite');
            $table->dropColumn('watched');
        });
    }
}
