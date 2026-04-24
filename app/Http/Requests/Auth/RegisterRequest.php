<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            // confirmed: so khớp với password_confirmation (KHÔNG đặt rule "confirmed" trên password_confirmation)
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'confirmed'],    
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Trường tên không được bỏ trống!',
            'email.required' => 'Trường email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
            'email.unique' => 'Email này đã tồn tại!',
            'password.required' => 'Trường mật khẩu không được bỏ trống!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự!',  
            'password_confirmation.required' => 'Trường xác nhận mật khẩu không được bỏ trống!',
        ];
    }
}
