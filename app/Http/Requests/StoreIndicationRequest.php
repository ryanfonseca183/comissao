<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Decimal;

class StoreIndicationRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'measuring_area' => str_replace(',', '.', $this->measuring_area),
        ]);
    }

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
        $service = $this->service_id;
        return [
            'user_id' => [
                Rule::excludeIf(! $this->routeIs('admin.*')),
                'required',
                'exists:users,id,deleted_at,NULL'
            ],
            'corporate_name' => 'string|max:255',
            'phone' => 'string|min:14|max:15',
            'email' => 'email|max:255',
            'doc_type' => 'integer|min:1|max:2',
            'doc_num' => ($this->doc_type == 1 ? 'cpf' : 'cnpj'),
            'service_id' => 'integer|exists:services,id,status,1',
            'employees_number' => [
                Rule::excludeIf(strpos(config('app.services_with_employees_number'), $service) === FALSE),
                'nullable',
                'integer',
            ],
            'measuring_area' => [
                Rule::excludeIf(strpos(config('app.services_with_measuring_area'), $service) === FALSE),
                new Decimal(13, 2),
                'numeric',
                'min:1'
            ],
            'note' => 'nullable|string|max:1000'
        ];
    }
}
