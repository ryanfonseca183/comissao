<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'doc_type' => ['integer', 'min:1', 'max:2'],
            'doc_num' => [$this->doc_type == 1 ? 'cpf' : 'cnpj', Rule::unique('users')->ignore($this->user)],
            'email' => ['email', Rule::unique('users')->ignore($this->user)],
            'phone' => 'string|min:14|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'O e-mail informado já está sendo usado',
            'doc_num.unique' => 'O documento informado já está sendo usado'
        ];
    }
}
