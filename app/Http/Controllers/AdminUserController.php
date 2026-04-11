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
        $this->view = [];
    }

    /**
     * Danh sách người dùng
     */
    public function index(Request $request)
    {
        $role = $request->query('role');
        $objUser = new User();
        
        // Lấy danh sách người dùng đã lọc và phân trang
        $this->view['listUser'] = $objUser->loadAllDataUserWithPage($role);
        
        // Thống kê số lượng (Luôn lấy tổng số trong DB, không phụ thuộc trang hiện tại)
        $this->view['countAll'] = User::count();
        $this->view['countStaffAdmin'] = User::whereIn('role', ['admin', 'staff'])->count();
        $this->view['countTrainer'] = User::where('role', 'trainer')->count();
        $this->view['countCustomer'] = User::where('role', 'user')->count();
        
        // Truyền role hiện tại để hiển thị active trên giao diện
        $this->view['currentRole'] = $role;

        return view('admin.user.index', $this->view);
    }

    /**
     * Form thêm mới người dùng
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Lưu người dùng mới
     */
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
            return redirect()->route('users.index')->with('success', 'Thêm mới người dùng thành công!');
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
            return redirect()->route('users.index')->with('error', 'Người dùng không tồn tại!');
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
            return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
        } else {
            return redirect()->back()->with('error', 'Cập nhật người dùng không thành công!');
        }
    }

    /**
     * Xóa người dùng
     */
    public function delete($id)
    {
        // Không cho phép tự xóa bản thân hoặc xóa admin chính (ID = 1)
        if ($id == auth()->id() || $id == 1) {
            return redirect()->route('users.index')->with('error', 'Bạn không thể xóa tài khoản này!');
        }

        $objUser = new User();
        $res = $objUser->deleteDataUser($id);
        
        if ($res) {
            return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
        } else {
            return redirect()->route('users.index')->with('error', 'Xóa người dùng không thành công!');
        }
    }
}
