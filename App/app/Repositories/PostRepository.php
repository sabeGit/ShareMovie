<?php
namespace App\Repositories;
use App\User;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface {

    public function getForUser($user) {
        return Post::where('user_id', $user->id)
               ->orderBy('created_at', 'asc')
               ->get();
    }

    /**
     * Request内容からPostを作成
     *
     * @param Request $request
     * @return Object
     */
    public function create($request) {
        $post = new Post();
        $post->content = $request->input('content');
        $post->user_id = $request->user()->id;
        $post->movie_id = $request->input('movie')['id'];
        $post->save();
        return $post;
        // $post->content = $request->input('content')
        // $request->user()->posts()->create([
        //     'content'    => $request->input('content'),
        //     'movie_id'   => 550,
        // ]);
    }
}
