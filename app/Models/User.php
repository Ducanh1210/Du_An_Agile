<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'height',
        'avatar_url',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /**
     * Lấy danh sách người dùng có phân trang
     */
    public function loadAllDataUserWithPage($role = null)
    {
        $query = User::query()->latest('id');

        if ($role) {
            if ($role === 'staff_admin') {
                $query->whereIn('role', ['admin', 'staff']);
            } else {
                $query->where('role', $role);
            }
        }

        return $query->paginate(10);
    }

    /**
     * Thêm mới người dùng
     */
    public function insertDataUser($params)
    {
        $params['email_verified_at'] = now();
        $res = User::query()->create($params);
        return $res;
    }

    /**
     * Lấy thông tin chi tiết người dùng theo ID
     */
    public function loadDataUserById($id)
    {
        $query = User::query()
            ->where('id', $id)
            ->first();
        return $query;
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function updateDataUser($id, $params)
    {
        $res = User::query()->where('id', $id)->update($params);
        return $res;
    }

    /**
     * Xóa người dùng
     */
    public function deleteDataUser($id)
    {
        $res = User::query()->where('id', $id)->delete();
        return $res;
    }

    /* Relationships */

    public function healthMetrics()
    {
        return $this->hasMany(HealthMetric::class);
    }

    public function rescheduleRequests()
    {
        return $this->hasMany(RescheduleRequest::class, 'requested_by');
    }

    public function sessionReports()
    {
        return $this->hasMany(SessionReport::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Lấy gói tập đang hoạt động
     */
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('end_date', '>=', now()->toDateString())
            ->first();
    }
}
