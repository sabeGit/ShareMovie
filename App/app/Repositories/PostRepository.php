<?php
namespace App\Repositories;
use App\User;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    /**
     * Request内容からPostを作成
     *
     * @param Request $request
     * @return Post
     */
    public function create($request)
    {
        $post = new Post();
        $post->content = $request->content;
        $post->user_id = $request->user()->id;
        $post->movie_id = $request->movie['id'];
        $post->save();
        return $post;
    }
}
