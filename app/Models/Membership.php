<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'memberships';

    protected $fillable = [
        'id',
        'name',
        'category',
        'description',
        'duration_days',
        'price',
        'allow_pt',
        'pt_sessions',
        'is_active',
        'created_at',
        'updated_at',
    ];

    /**
     * Lấy danh sách gói tập có phân trang
     */
    public function loadAllDataMembershipWithPage()
    {
        $query = Membership::query()
            ->latest('id')
            ->paginate(10);
        return $query;
    }

    /**
     * Thêm mới gói tập
     */
    public function insertDataMembership($params)
    {
        $params['is_active'] = 1;
        $params['created_at'] = date('Y-m-d H:i:s');
        $res = Membership::query()->create($params);
        return $res;
    }

    /**
     * Lấy thông tin chi tiết gói tập theo ID
     */
    public function loadDataMembershipById($id)
    {
        $query = Membership::query()
            ->where('id', $id)
            ->first();
        return $query;
    }

    /**
     * Cập nhật thông tin gói tập
     */
    public function updateDataMembership($id, $params)
    {
        $params['updated_at'] = date('Y-m-d H:i:s');
        $res = Membership::query()->where('id', $id)->update($params);
        return $res;
    }

    /**
     * Xóa gói tập
     */
    public function deleteDataMembership($id)
    {
        $res = Membership::query()->where('id', $id)->delete();
        return $res;
    }
}
