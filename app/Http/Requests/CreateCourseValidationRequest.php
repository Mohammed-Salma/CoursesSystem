<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourseValidationRequest extends FormRequest
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
            'name'=>'required|string|max:255',
            'active'=>'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الكورس مطلوب',
            'name.string' => 'اسم الكورس يجب أن يكون نصًا',
            'name.max' => 'اسم الكورس يجب ألا يزيد عن 255 حرفًا',
            'active.required' => 'حالة التفعيل مطلوبة',
        ];
    }
}
