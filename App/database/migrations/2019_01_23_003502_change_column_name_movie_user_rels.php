<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameMovieUserRels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movie_user_rels', function (Blueprint $table) {
            $table->renameColumn('is_watched', 'watched');
            $table->renameColumn('is_want', 'favorite');
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
            $table->renameColumn('watched', 'is_watched');
            $table->renameColumn('favorite', 'is_want');
        });
    }
}
