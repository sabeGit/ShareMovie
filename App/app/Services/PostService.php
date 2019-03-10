<?php

namespace App\Services;

use App\Repositories\PostRepositoryInterface;

class PostService {

    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo) {
        $this->postRepo = $postRepo;
    }

    /**
     * Request内容からPostを作成
     *
     * @param Request $request
     * @return Object
     */
    public function create($request) {
        return $this->postRepo->create($request);
    }

}
