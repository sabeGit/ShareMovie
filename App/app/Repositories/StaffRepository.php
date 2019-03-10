<?php
namespace App\Repositories;
use App\Models\Staff;

class StaffRepository implements StaffRepositoryInterface {

    protected $staff;

    public function __construct(Staff $staff) {
        $this->staff = $staff;
    }

    /**
     * idからstaffを取得
     *
     * @var $staff_id
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getById($staff_id) {
        return $this->staff->find($staff_id);
    }

    /**
     * staffを作成
     *
     * @var $obj ['casts'=>[staffInfo], 'crews'=>[staffInfo]]
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($obj) {
        $creditArray = array();
        foreach($obj as $job => $staffInfos) {
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
