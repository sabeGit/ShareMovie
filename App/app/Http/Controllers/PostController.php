<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\PostService;
use App\Services\MovieService;

class PostController extends Controller
{
    /**
     * ポストサービスクラスインスタンス
     */
    protected $postService;
    /**
     * 映画サービスクラスインスタンス
     */
    protected $movieService;

    /**
     * コンストラクタ
     */
    public function __construct(
        PostService $postService,
        MovieService $movieService
    ) {
        $this->middleware('auth');
        $this->postService = $postService;
        $this->movieService = $movieService;
    }

    /**
     * コメント投稿
     *
     * @param PostRequest $request
     * @return json
     */
    public function create(PostRequest $request)
    {
        // 対象映画を映画マスタから取得 or 映画マスタに存在しない場合、requestをもとに映画レコードを作成
        $movie = $this->movieService->getMovieFromDB($request->movie);

        // requestをもとにpostを作成
        $post = $this->postService->create($request);

        return response()->json($post);
    }
}
