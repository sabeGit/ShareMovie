<?php

namespace App\Repositories;

interface StaffRepositoryInterface
{
    /**
     * idからstaffを取得
     *
     * @var $staff_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($staff_id);

    /**
     * staffを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj);
}
