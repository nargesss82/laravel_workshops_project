<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubchapterRequest extends FormRequest
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
            'chapter_id' => 'required|exists:chapters,id',
            'title' => 'required|string',
            'is_free' => 'nullable|boolean',
            'price' => 'nullable|numeric',
        ];


        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['chapter_id'] = 'sometimes|exists:chapters,id';
            $rules['title'] = 'sometimes|string';
            $rules['is_free'] = 'sometimes|boolean';
            $rules['price'] = 'sometimes|numeric';
        }
        return $rules;
    }
}
