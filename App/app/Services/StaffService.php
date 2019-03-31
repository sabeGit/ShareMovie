<?php

namespace App\Services;

use App\Repositories\StaffRepositoryInterface;

class StaffService
{

    /**
     * スタッフサービスクラスインスタンス
     */
    protected $staffRepo;

    /**
     * コンストラクタ
     *
     * @return void
     */
    public function __construct(StaffRepositoryInterface $staffRepo)
    {
        $this->staffRepo = $staffRepo;
    }

    /**
     * staffを作成
     *
     * @param object $staff
     * @return Staff
     */
    public function create($staff)
    {
        return $this->staffRepo->create($staff);
    }

}
