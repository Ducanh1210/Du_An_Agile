<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'membership_id' => 'required|exists:memberships,id',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'membership_id.required' => 'Vui lòng chọn gói tập.',
            'membership_id.exists' => 'Gói tập không tồn tại.',
            'phone.required' => 'Vui lòng nhập số điện thoại nhận thông báo.',
            'address.required' => 'Vui lòng nhập địa chỉ của bạn.',
        ];
    }
}
