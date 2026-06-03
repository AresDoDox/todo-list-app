<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:0,1,2',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tên công việc.',
            'title.string' => 'Tên công việc phải là một chuỗi.',
            'title.max' => 'Tên công việc không được vượt quá 255 ký tự.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'due_date.date' => 'Hạn chót phải là một ngày hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái công việc.',
            'status.in' => 'Trạng thái công việc không hợp lệ.',
        ];
    }
}