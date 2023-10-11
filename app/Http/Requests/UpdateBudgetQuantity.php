<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PaymentTypeEnum;
use App\Rules\Decimal;

class UpdateBudgetQuantity extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'measuring_area' => $this->measuring_area ? str_replace(',', '.', $this->measuring_area): null,
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
        $paymentType = $this->company->budget->payment_type;
        return [
            'measuring_area' => [
                'exclude_with:employees_number',
                Rule::requiredIf($paymentType == PaymentTypeEnum::METRO),
                new Decimal(13, 2)
                
            ],
            'employees_number' => [
                'exclude_with:measuring_area',
                Rule::requiredIf($paymentType == PaymentTypeEnum::VIDA),
                'integer',
                'min:1'
            ]
        ];
    }
}
