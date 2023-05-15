<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off">
    @csrf
    @method($method ?? 'POST')
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="finish_month" :value="__('Finishing Month')" />
            <x-select name="finish_month" class="mt-1 block w-full" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{$i}}" @if($budget->finish_month == $i) selected @endif>{{ Carbon\Carbon::now()->month($i)->monthName }}</option>
                @endfor
            </x-select>
            <x-input-error :messages="$errors->get('finish_month')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="number" :value="__('Proposal Number')" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full integer" :value="old('number', $budget->number)" required/>
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="payment_type" :value="__('Payment Type')" />
            <x-select id="payment_type" name="payment_type" class="mt-1 block w-full" :collection="App\Enums\PaymentTypeEnum::array()" :optionSelected="$budget->payment_type" required />
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
            <x-text-input id="comission" name="commission" type="number" max="100" min="1" class="mt-1 block w-full" :value="$budget->commission" required />
            <x-input-error :messages="$errors->get('commission')" class="mt-2" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_payment_date" :value="__('First Payment Date')" />
                <x-text-input id="first_payment_date" name="first_payment_date" type="date" class="mt-1 block w-full" :value="old('first_payment_date', $budget->first_payment_date)" required/>
                <x-input-error :messages="$errors->get('first_payment_date')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="payment_term" :value="__('Payment Time')" />
                <x-text-input id="payment_term" name="payment_term" type="number" min="1" class="mt-1 block w-full" :value="old('payment_term', $budget->payment_term)" required />
                <x-input-error :messages="$errors->get('payment_term')" class="mt-2" />
            </div>
        </div>
    </fieldset>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
        @if (session('status') === 'saved')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</form>

@push('js')
    <script>
        $('#payment_type').change(function(){
            toggleControl($("#employees_number_control"), this.value != 1);
            toggleControl($("#measuring_area_control"), this.value != 3);
        }).trigger('change');
        function toggleControl(control, bool) {
            control.toggleClass('hidden', bool).find('input').prop('disabled', bool)
        }
    </script>
@endpush