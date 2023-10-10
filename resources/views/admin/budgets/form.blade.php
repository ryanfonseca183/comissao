@if($company->statusEqualTo('ORCADO'))
    <form
      method="POST"
      action="{{ route('admin.indications.budget.status.update', $company) }}"
      class="rounded-md border border-gray-300 p-4 mt-5">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-medium text-gray-900">A empresa aceitou a proposta?</h2>
        <p class="mb-3">Clique em um dos botões abaixo para fechar ou recusar</p>
        <div class="flex items-center gap-4 mb-3">
            <x-primary-button type="button" id="close_button">
                {{ __('Fechar') }}
            </x-primary-button>
            <x-danger-button
                type="submit"
                name="status"
                value="{{ App\Enums\IndicationStatusEnum::RECUSADO }}">
                    {{ __('Recusar') }}
            </x-danger-button>
        </div>
        <div class="border border-gray-300 p-4 rounded-md" id="contract_number_form" @if(! $errors->has('contract_number')) style="display:none;" @endif>
            <div>
                <x-input-label for="contract_number" :value="__('Contract Number')" class="mb-1" />
                <div class="relative flex flex-wrap items-stretch">
                    <x-text-input
                      :value="old('contract_number', $budget->contract_number)"
                      class="border-e-0 rounded-e-none grow"
                      name="contract_number"
                      id="contract_number"
                      type="text" />
                    <x-primary-button
                      style="font-size: 0.65rem; padding: 0.5rem 0.75rem"
                      class="rounded-s-none rounded-e-md"
                      type="submit">
                        <x-icons.check-circle width="24" height="24" class="w-3 h-3 me-2"/>
                        Salvar
                    </x-primary-button>
                </div>
                <x-input-error :messages="$errors->get('contract_number')" class="mt-2" />
            </div>
        </div>
        <span class="leading-none text-xs">
            Após fechar ou recusar um orçamento, não será mais possível editar as informações.
        </span>
    </form>
@endif
<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off" id="budget">
    @csrf
    @method($method ?? 'POST')
    @if($company->statusEqualTo('FECHADO'))
        <div>
            <x-input-label for="contract_number" :value="__('Contract Number')" />
            <x-text-input type="text" id="contract_number" class="mt-1 block w-full" value="{{$budget->contract_number}}" />
        </div>
    @endif
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="finish_month" :value="__('Finishing Month')" />
            <x-select name="finish_month" class="mt-1 block w-full" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{$i}}" @if(old('finish_month', $budget->finish_month) == $i) selected @endif>{{ Carbon\Carbon::now()->month($i)->monthName }}</option>
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
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="payment_type" :value="__('Payment Type')" />
            <x-select id="payment_type" name="payment_type" class="mt-1 block w-full" :collection="App\Enums\PaymentTypeEnum::array()" :optionSelected="old('payment_type', $budget->payment_type)" required />
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
        <x-text-input id="measuring_area" name="measuring_area" type="text" class="mt-1 block w-full decimal" :value="old('measuring_area', $budget->measuring_area)" required/>
        <x-input-error :messages="$errors->get('measuring_area')" class="mt-2" />
    </div>
    <div id="employees_number_control">
        <x-input-label for="employees_number" :value="__('Employees Number')" />
        <x-text-input id="employees_number" name="employees_number" type="text" class="mt-1 block w-full integer" :value="old('employees_number', $budget->employees_number)" required/>
        <x-input-error :messages="$errors->get('employees_number')" class="mt-2" />
    </div>
    <fieldset class="rounded-md border border-gray-300 p-4">
        <legend>Comissão</legend>
        <div class="mb-6">
            <x-input-label for="commission" :value="__('Percent')" />
            <x-text-input id="comission" name="commission" type="number" max="100" min="1" class="mt-1 block w-full" :value="old('commission', $budget->commission)" required />
            <x-input-error :messages="$errors->get('commission')" class="mt-2" />
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_payment_date" :value="__('First Payment Date')" />
                <x-text-input id="first_payment_date" name="first_payment_date" type="date" min="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full" :value="old('first_payment_date', $budget->first_payment_date?->format('Y-m-d'))" required/>
                <x-input-error :messages="$errors->get('first_payment_date')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="payment_term" :value="__('Payment Time')" />
                <x-text-input id="payment_term" name="payment_term" type="number" min="1" class="mt-1 block w-full" :value="old('payment_term', $budget->payment_term)" required />
                <x-input-error :messages="$errors->get('payment_term')" class="mt-2" />
            </div>
        </div>
    </fieldset>
    @if($company->canBeUpdated)
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    @endif
</form>


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
            $(`label[for="value"]`).text(labels[this.value])
        }).trigger('change');

        function toggleControl(control, bool) {
            control.toggleClass('hidden', bool).find('input').prop('disabled', bool)
        }
    </script>
@endpush