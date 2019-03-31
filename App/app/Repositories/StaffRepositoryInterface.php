<?php

namespace App\Repositories;

interface StaffRepositoryInterface
{

    /**
     * staffを作成
     *
     * @param object $staff
     * @return Staff
     */
    public function create($staff);
}
