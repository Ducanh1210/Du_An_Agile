<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'category' => 'required|in:gym,yoga',
            'description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'allow_pt' => 'nullable|integer|in:0,1',
            'pt_sessions' => 'required_if:allow_pt,1|integer|min:0',
            'is_active' => 'nullable|integer|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên gói tập không được để trống.',
            'category.required' => 'Loại gói tập không được để trống.',
            'category.in' => 'Loại gói tập phải là gym hoặc yoga.',
            'duration_days.required' => 'Thời gian hiệu lực không được để trống.',
            'duration_days.integer' => 'Thời gian hiệu lực phải là số nguyên.',
            'price.required' => 'Giá gói tập không được để trống.',
            'price.numeric' => 'Giá gói tập phải là số.',
            'pt_sessions.required_if' => 'Số buổi PT là bắt buộc khi gói có kèm PT.',
        ];
    }
}
