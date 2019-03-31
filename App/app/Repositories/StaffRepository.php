<?php
namespace App\Repositories;
use App\Models\Staff;

class StaffRepository implements StaffRepositoryInterface {

    protected $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    /**
     * staffを作成
     *
     * @param object $staff
     * @return Staff
     */
    public function create($staff)
    {
        $creditArray = array();
        foreach($staff as $job => $staffInfos) {
            $targetStaffArray = array();
            foreach($staffInfos as $staffInfo) {
                $targetStaff = Staff::updateOrCreate(
                    ['id'   => $staffInfo['id']],
                    ['name' => $staffInfo['name']]
                );
                $targetStaffArray[] = $targetStaff;
                $creditArray[$job] = $targetStaffArray;
            }
        }

        return $creditArray;
    }
}
