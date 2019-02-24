<?php

namespace App\Http\Controllers;

use App\Post;
// use App\Repositories\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {

    // public function __construct(PostRepositoryInterface $postRepo) {
    //     $this->middleware('auth');
    //     $this->postRepo = $postRepo;
    // }
    public function __construct() {
        $this->middleware('auth');
    }

    public function create(Request $request) {
        $request->user()->posts()->create([
            'content'    => $request->content,
            'movie_id'   => $request->movieId,
        ]);
        // $this->postRepo->createPost($request);
    }

    // public function index(Request $request) {
    //     return $this->postRepo->getForUser($request->user());
    // }
}
