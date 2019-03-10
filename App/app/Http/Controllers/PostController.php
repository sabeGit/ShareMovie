<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PostService;
use App\Services\MovieService;

class PostController extends Controller {

    protected $postService, $movieService;

    public function __construct(PostService $postService, MovieService $movieService) {
        $this->middleware('auth');
        $this->postService = $postService;
        $this->movieService = $movieService;
    }

    public function create(Request $request) {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->input('movie'));
        \Debugbar::info($movie->id);
        \Debugbar::info($request->input('movie')['id']);
        $post = $this->postService->create($request);
        return $post;
    }

    // public function index(Request $request) {
    //     return $this->postRepo->getForUser($request->user());
    // }
}
