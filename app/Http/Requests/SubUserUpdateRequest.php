<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubUserUpdateRequest extends FormRequest
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
            'subuser_id' => ['required'],
            'label' => ['required', 'string'],
            'threads' => ['nullable','integer','min:0','max:200'],
        ];
    }
}
