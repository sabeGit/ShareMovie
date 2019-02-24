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

    public function create($request) {
        $request->user()->posts()->create([
            'watched' => $request->watched,
            'content'    => $request->content,
            'movie_id'   => $request->movieId,
        ]);
    }
}
