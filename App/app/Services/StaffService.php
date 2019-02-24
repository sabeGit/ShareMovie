<?php

namespace App\Services;

use App\Repositories\StaffRepositoryInterface;

class StaffService {

    protected $staffRepo;

    public function __construct(StaffRepositoryInterface $staffRepo) {
        $this->staffRepo = $staffRepo;
    }

    /**
     * idからstaffを取得
     *
     * @var $staff_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($staff_id) {
        return $this->staffRepo->getById($staff_id);
    }

    /**
     * staffを作成
     *
     * @var $obj id, title, poster_path, overview
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj) {
        return $this->staffRepo->create($obj);
    }

}
