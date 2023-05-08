<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIndicationRequest extends FormRequest
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
            'corporate_name' => 'string|max:255',
            'email' => 'email|max:255',
            'doc_type' => 'integer|min:1|max:2',
            'doc_num' => ($this->doc_type == 1 ? 'cpf' : 'cnpj'),
            'phone' => 'string|min:14|max:15',
        ];
    }
}
