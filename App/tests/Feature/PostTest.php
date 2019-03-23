<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = factory(User::class, 'registered')->create();
    }

    public function testSuccessPostComment()
    {
        $request['content'] = 'test_comment';
        $request['movie']   = array(
                                  'id' => 1,
                                  'title' => 'test_title',
                                  'overview' => 'test_overview',
                                  'poster_path' => '',
                                  'credits' => [
                                      'cast' => [],
                                      'crew' => [],
                                  ],
                              );
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', route('createPost'), $request);
        $response->assertStatus(200);
    }

    public function testOver560Comment()
    {
        $response = $this->actingAs($this->user, 'api')
                         ->json('POST', route('createPost'), [
                             'content' => str_repeat('a', 561),
                         ]);

        $response->assertStatus(400)
                 ->assertJson([
                     'messages' => [
                         'content' => [
                             'コメントは560文字以内で入力してください',
                         ],
                     ],
                 ]);
    }
}
