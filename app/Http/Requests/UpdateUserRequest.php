<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:user,staff,admin,trainer,content_admin',
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ tên không được để trống.',
            'name.string' => 'Họ tên phải là chuỗi.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại trên hệ thống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'role.required' => 'Vui lòng chọn vai trò.',
            'role.in' => 'Vai trò không hợp lệ.',
            'avatar_url.image' => 'Tệp tải lên phải là hình ảnh.',
            'avatar_url.mimes' => 'Ảnh đại diện phải thuộc định dạng: jpeg, png, jpg, gif.',
            'avatar_url.max' => 'Dung lượng ảnh không được vượt quá 2MB.',
        ];
    }
}
