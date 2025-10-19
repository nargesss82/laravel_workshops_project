<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
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
        $rules= [
            'user_id'=>'required|exists:users,id',
            'workshop_id'=>'required|exists:workshops,id',
        ];
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['user_id'] = 'sometimes|exists:users,id';
            $rules['workshop_id'] = 'sometimes|exists:workshops,id';
        }
        return $rules;
    }
}
