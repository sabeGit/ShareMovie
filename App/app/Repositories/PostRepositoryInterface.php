<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * Request内容からPostを作成
     *
     * @param Request $request
     * @return Post
     */
    public function create($request);
}
