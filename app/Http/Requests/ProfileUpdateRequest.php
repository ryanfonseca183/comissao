<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $doc_type = $this->user()->doc_type == 0 ? 'cpf' : 'cnpj';
        return [
            'name' => ['string', 'max:255'],
            'phone' => 'string|min:14|max:15',
            'doc_num' => ['string', $doc_type, Rule::unique(User::class, 'doc_num')->ignore($this->user()->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
