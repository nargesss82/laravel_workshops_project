<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'description' => 'nullable',
            'status' => 'required|in:active,inactive',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['title'] = 'sometimes|string';
            $rules['teacher_id'] = 'sometimes|exists:users,id';
            $rules['status'] = 'sometimes|in:active,inactive';
        }
        return $rules;
    }

}
