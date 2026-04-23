<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role !== 'admin') {
                abort(403, 'Trang này chỉ dành cho Quản trị viên (Admin).');
            }
            return $next($request);
        });
        
        $this->view = [];
    }

    /**
     * Danh sách người dùng
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('search');
        $objUser = new User();
        
        // Lấy danh sách người dùng đã lọc, tìm kiếm và phân trang
        $this->view['listUser'] = $objUser->loadAllDataUserWithPage($role, $search);
        
        // Thống kê số lượng (Loại trừ Admin ID 1)
        $this->view['countAll'] = User::where('id', '!=', 1)->count();
        $this->view['countStaffAdmin'] = User::where('id', '!=', 1)->whereIn('role', ['admin', 'staff'])->count();
        $this->view['countTrainer'] = User::where('id', '!=', 1)->where('role', 'trainer')->count();
        $this->view['countCustomer'] = User::where('id', '!=', 1)->where('role', 'user')->count();
        
        // Truyền role và search hiện tại để hiển thị trên giao diện
        $this->view['currentRole'] = $role;
        $this->view['currentSearch'] = $search;

        return view('admin.user.index', $this->view);
    }

    /**
     * Form thêm mới người dùng
     */
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        
        // Xử lý upload ảnh đại diện
        if ($request->hasFile('avatar_url')) {
            $path = $request->file('avatar_url')->store('avatars', 'public');
            $data['avatar_url'] = '/storage/' . $path;
        }

        $objUser = new User();
        $res = $objUser->insertDataUser($data);
        
        if ($res) {
            return redirect()->route('admin.users.index')->with('success', 'Thêm mới người dùng thành công!');
        } else {
            return redirect()->back()->with('error', 'Thêm mới người dùng không thành công!');
        }
    }

    /**
     * Form chỉnh sửa người dùng
     */
    public function edit($id)
    {
        $objUser = new User();
        $this->view['userDetail'] = $objUser->loadDataUserById($id);
        
        if (empty($this->view['userDetail'])) {
            return redirect()->route('admin.users.index')->with('error', 'Người dùng không tồn tại!');
        }
        
        return view('admin.user.edit', $this->view);
    }

    /**
     * Cập nhật thông tin người dùng
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Xử lý upload ảnh đại diện mới
        if ($request->hasFile('avatar_url')) {
            $user = User::findOrFail($id);
            
            // Xóa ảnh cũ nếu tồn tại
            if ($user->avatar_url && str_contains($user->avatar_url, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $user->avatar_url);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar_url')->store('avatars', 'public');
            $data['avatar_url'] = '/storage/' . $path;
        }
        
        $objUser = new User();
        $res = $objUser->updateDataUser($id, $data);
        
        if ($res) {
            return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công!');
        } else {
            return redirect()->back()->with('error', 'Cập nhật người dùng không thành công!');
        }
    }

    /**
     * Khóa/Mở khóa người dùng
     */
    public function toggleStatus($id)
    {
        // Không cho phép tự khóa bản thân hoặc khóa admin chính (ID = 1)
        if ($id == auth()->id() || $id == 1) {
            return redirect()->route('admin.users.index')->with('error', 'Bạn không thể khóa tài khoản này!');
        }

        $user = User::findOrFail($id);
        $newStatus = $user->is_active == 1 ? 0 : 1;
        
        $res = $user->update(['is_active' => $newStatus]);
        
        if ($res) {
            $msg = $newStatus == 0 ? 'Đã khóa tài khoản thành công!' : 'Đã mở khóa tài khoản thành công!';
            return redirect()->route('admin.users.index')->with('success', $msg);
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Thao tác không thành công!');
        }
    }
}
