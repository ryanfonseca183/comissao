<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Decimal;
use Illuminate\Validation\Rule;
use App\Enums\PaymentTypeEnum;


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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $paymentByArea = $this->payment_type == PaymentTypeEnum::METRO;
        $hasComission = $paymentByArea || (int) $this->employees_number > 0;

        return [
            'contract_number' => [
                Rule::excludeIf($this->company->statusDiffFrom('FECHADO')),
                'string',
                'max:255',
            ],
            'finish_month' => 'integer|between:1,12',
            'number' => 'string|max:255',
            'expiration_date' => 'date_format:Y-m-d|after_or_equal:now',
            'payment_type' => 'integer|between:1,3',
            'value' => [new Decimal(13, 2)],
            'measuring_area' => [
                'nullable',
                Rule::requiredIf($paymentByArea),
                new Decimal(13, 2),
                'numeric',
                'min:1',
            ],
            'employees_number' => [
                'nullable',
                'integer',
            ],
            'commission' => [
                'nullable',
                Rule::requiredIf($hasComission),
                'integer',
                'min:1',
                'max:100'
            ],
            'first_payment_date' => [
                Rule::excludeIf($this->company->statusEqualTo('FECHADO')),
                'nullable',
                Rule::requiredIf($hasComission),
                'date_format:Y-m-d',
            ],
            'payment_term' => [
                'nullable',
                Rule::requiredIf($hasComission),
                'integer',
                'min:' . $this->company->budget?->payment_term ?: 1,
                'max:255',
            ]
        ];
    }
}
