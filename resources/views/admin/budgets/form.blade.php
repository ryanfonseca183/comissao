<div id="budget" class="my-6 space-y-6">
    @if($company->statusIn(['FECHADO', 'RESCINDIDO']))
        <div>
            <x-input-label for="contract_number" :value="__('Contract Number')" />
            <x-text-input type="text" id="contract_number" name="contract_number" class="mt-1 block w-full" value="{{$budget->contract_number}}" />
        </div>
    @endif
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="finish_month" :value="__('Finishing Month')" />
            <x-select name="finish_month" class="mt-1 block w-full" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{$i}}" @if(old('finish_month', $budget->finish_month) == $i) selected @endif>
                        {{ now()->setDay(1)->setMonth($i)->monthName }}
                    </option>
                @endfor
            </x-select>
            <x-input-error :messages="$errors->get('finish_month')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="number" :value="__('Proposal Number')" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full" :value="old('number', $budget->number)" required/>
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>
    </div>
    <div>
        <x-input-label for="expiration_date" :value="__('Expiration Date')" />
        <x-text-input id="expiration_date" name="expiration_date" type="date" class="mt-1 block w-full" :min="now()->format('Y-m-d')" :value="old('expiration_date', $budget->expiration_date?->format('Y-m-d'))" required/>
        <x-input-error :messages="$errors->get('expiration_date')" class="mt-2" />
    </div>
    <div class="grid grid-cols-2 gap-4">
        @php
            $paymentType = old('payment_type');
            if(strpos(config('app.services_with_measuring_area'), $company->service_id) !== FALSE) {
                $paymentType = App\Enums\PaymentTypeEnum::METRO;
            }
            if(strpos(config('app.services_with_employees_number'), $company->service_id) !== FALSE) {
                $paymentType = App\Enums\PaymentTypeEnum::VIDA;
            }
        @endphp
        <div>
            <x-input-label for="payment_type" :value="__('Payment Type')" />
            <x-select id="payment_type" name="payment_type" class="mt-1 block w-full" :collection="App\Enums\PaymentTypeEnum::array()" :optionSelected="$budget->payment_type ?: $paymentType" required />
            <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="value" :value="__('Budget Value')" />
            <x-text-input id="value" name="value" type="text" class="mt-1 block w-full money" :value="old('value', $budget->value)" required/>
            <x-input-error :messages="$errors->get('value')" class="mt-2" />
        </div>
    </div>
    <div id="measuring_area_control">
        <x-input-label for="measuring_area" :value="__('Measuring Area')" />
        <x-text-input id="measuring_area" name="measuring_area" type="text" class="mt-1 block w-full decimal" :value="$budget->measuring_area ?: $company->measuring_area" required/>
        <x-input-error :messages="$errors->get('measuring_area')" class="mt-2" />
    </div>
    @php 
        $employees = $budget->employees_number;
        if(empty($employees) && request()->routeIs('admin.indications.budget.create')) {
            $employees = $company->employees_number;
        }
    @endphp
    <div id="employees_number_control">
        <x-input-label for="employees_number" :value="__('Employees Number')" />
        <x-text-input id="employees_number" name="employees_number" type="text" class="mt-1 block w-full integer" :value="old('employees_number', $employees)" />
        <x-input-error :messages="$errors->get('employees_number')" class="mt-2" />
    </div>
    <fieldset class="rounded-md border border-gray-300 p-4" id="comission-fieldset">
        <legend>Comissão</legend>
        <div class="mb-6">
            <x-input-label for="commission" :value="__('Percent')" />
            <x-text-input id="commission" name="commission" type="number" max="100" min="1" class="mt-1 block w-full" :value="old('commission', $budget->commission)" required/>
            <x-input-error :messages="$errors->get('commission')" class="mt-2" />
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_payment_date" :value="__('First Payment Date')" />
                <x-text-input id="first_payment_date" name="first_payment_date" type="date" class="mt-1 block w-full" :readonly="$budget->first_payment_date != null" :disabled="$budget->first_payment_date != null" :value="old('first_payment_date', $budget->first_payment_date?->format('Y-m-d'))" required />
                <x-input-error :messages="$errors->get('first_payment_date')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="payment_term" :value="__('Installment Number')" />
                <x-text-input id="payment_term" name="payment_term" type="number" class="mt-1 block w-full" min="1" :value="old('payment_term', $budget->payment_term)" required />
                <x-input-error :messages="$errors->get('payment_term')" class="mt-2" />
            </div>
        </div>
    </fieldset>
    @if($company->canBeUpdated)
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    @endif
</div>

@push('js')
    <script>
        const labels = {
            1: 'Valor por Vida ativa',
            2: 'Valor da Proposta',
            3: 'Valor por Metro quadrado'
        }
        $("#close_button").on('click', function(){
            $("#contract_number_form").slideToggle('fast');
        })
        $('#payment_type').change(function(){
            toggleControl($("#employees_number_control"), this.value != 1);
            toggleControl($("#measuring_area_control"), this.value != 3);
            toggleControl($("#comission-fieldset"), this.value == 1 && Number($("#employees_number").val()) == 0)
            $(`label[for="value"]`).text(labels[this.value])
        }).trigger('change');

        $("#employees_number").on('input', function(){
            toggleControl($("#comission-fieldset"), Number(this.value) == 0)
        })
        function toggleControl(control, bool) {
            control.toggleClass('hidden', bool).find('input:not([readonly])').prop('disabled', bool)
        }
    </script>
@endpush