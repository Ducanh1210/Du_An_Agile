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
    public function loadAllDataUserWithPage()
    {
        $query = User::query()
            ->latest('id')
            ->paginate(10);
        return $query;
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

    /**
     * Gói đăng ký của người dùng
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Lịch đặt chỗ của người dùng
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
