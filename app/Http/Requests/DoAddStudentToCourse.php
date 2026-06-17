<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DoAddStudentToCourse extends FormRequest
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
            'studentID' => 'required',
            'enrolment_date' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'studentID.required' => 'حقل الطالب مطلوب',
            'enrolment_date.required' => 'تاريخ التسجيل مطلوب',
        ];
    }
}
