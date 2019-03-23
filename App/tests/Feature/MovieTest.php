<?php

namespace Tests\Feature;

use App\User;
use App\Models\Movie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        // テストユーザー作成
        $this->users = factory(User::class, 'registered', 2)->create();
    }
   /**
    * TMDbの映画を検索
    */
    public function testSearchMoviesFromTMDb()
    {
        $request['freeword'] = 'ファイト';
        $response = $this->actingAs($this->users[0], 'api')
                         ->json('GET', route('searchMovies'), $request);
        $response->assertStatus(200);
    }

    /**
     * TMDbの人気映画を取得
     */
    public function testGetPopularMovieFromTMDB()
    {
        $response = $this->actingAs($this->users[0], 'api')
                         ->json('GET', route('getPopularMovieFromTMDB'));
        $response->assertStatus(200);
    }

    /**
     * TMDbの映画を取得(追加プロパティ(お気に入りや視聴済みなど)なし)
     */
    public function testGetMovieByIdWithoutAdditionalProperties()
    {
        $response = $this->actingAs($this->users[0], 'api')
                         ->json('GET', route('getMovieById'), [
                             'movieId' => 550,
                         ]);
        $response->assertStatus(200);
    }

    /**
     * TMDbの映画を取得(追加プロパティあり)
     */
    public function testGetMovieByIdWithAdditionalProperties()
    {
        $getMovieRes = $this->actingAs($this->users[0], 'api')
                         ->json('GET', route('getMovieById'), [
                             'movieId' => 550,
                         ]);

        $editFavRes = $this->actingAs($this->users[0], 'api')
                           ->json('POST', route('editFavoriteMovie'), [
                               'favorite' => true,
                               'movie'    => $getMovieRes->getData(),
                           ]);
        $editFavRes->assertStatus(200);

        $editWatchedRes = $this->actingAs($this->users[0], 'api')
                               ->json('POST', route('editWatchedMovie'), [
                                   'watched' => true,
                                   'movie'   => $getMovieRes->getData(),
                               ]);
        $editWatchedRes->assertStatus(200);

        $editRatingRes = $this->actingAs($this->users[0], 'api')
                              ->json('POST', route('editMovieRating'), [
                                  'rating' => 4,
                                  'movie'  => $getMovieRes->getData(),
                              ]);
        $editRatingRes->assertStatus(200);

        $movieWithAdditionalProperties = $this->actingAs($this->users[0], 'api')
                                              ->json('GET', route('getMovieById'), [
                                                  'movieId' => 550,
                                              ]);

        $movieWithAdditionalProperties->assertStatus(200)
                                      ->assertJson([
                                          'avgRating'   => 4,
                                      ]);
    }
}
