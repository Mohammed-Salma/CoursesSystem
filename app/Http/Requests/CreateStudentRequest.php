<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
            'active'=>'required',
            'country_id'=>'required',
            'phone'=>'required',
            'nationalID'=>'required|unique:students,nationalID',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'اسم الطالب مطلوب',
            'name.string' => 'اسم الطالب يجب أن يكون نصًا',
            'name.max' => 'اسم الطالب يجب ألا يزيد عن 255 حرفًا',
            'active.required' => 'حالة التفعيل مطلوبة',
            'country_id.required' => 'حقل الدولة مطلوب',
            'phone.required' => 'حقل الهاتف مطلوب',
            'nationalID.required' => 'حقل الرقم القومي للهوية مطلوب',
            'nationalID.unique' => 'الرقم القومي للهوية مستخدم بالفعل',
        ];
    }

}
