<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateTrainingCoursesRequest extends FormRequest
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
            'courseID'=>'required',
            'price'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
        ];
    }
    public function messages(): array
    {
        return [
            'courseID.required' => 'حقل الكورس مطلوب',
            'price.required' => 'حقل السعر مطلوب',
            'start_date.required' => 'حقل تاريخ البدء مطلوب',
            'end_date.required' => 'حقل تاريخ الانتهاء مطلوب',
        ];
    }

}
