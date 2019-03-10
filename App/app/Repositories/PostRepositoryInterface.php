<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    /**
     * Userに紐づくPostを取得
     *
     * @var User $user
     * @return object
     */
    public function getForUser($user);

    /**
     * Request内容からPostを作成
     *
     * @param Request $request
     * @return Object
     */
    public function create($request);
}
