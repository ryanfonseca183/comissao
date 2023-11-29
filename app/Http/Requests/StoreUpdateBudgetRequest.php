<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Decimal;

class StoreUpdateBudgetRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        //Remove os pontos que delimitam as ordens de grandeza
        $valor = str_replace('.', '', $this->value);
        //Substitui a virgula que delimita as casas decimais por um ponto
        $valor = str_replace(',', '.', $valor);

        $this->merge([
            'value' => $valor,
            'measuring_area' => $this->payment_type == 3 ? str_replace(',', '.', $this->measuring_area): null,
            'employees_number' => $this->payment_type == 1 ? $this->employees_number : null
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! $this->company->budget || $this->company->budget->created_at->diffInHours(now()) < 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'finish_month' => 'integer|between:1,12',
            'number' => 'string|max:255',
            'payment_type' => 'integer|between:1,3',
            'value' => [new Decimal(13, 2)],
            'measuring_area' => ['nullable', new Decimal(13, 2)],
            'employees_number' => 'nullable|integer|min:1',
            'commission' => 'integer|min:1|max:100',
            'first_payment_date' => 'date_format:Y-m-d',
            'payment_term' => 'integer|min:1|max:255',
        ];
    }
}
