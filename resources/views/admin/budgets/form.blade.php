<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off">
    @csrf
    @method($method ?? 'POST')
    <div>
        <x-input-label for="finish_month" :value="__('Finishing Month')" />
        <x-select name="finish_month" class="mt-1 block w-full" required>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{$i}}" @if($budget->finish_month == $i) selected @endif>{{ Carbon\Carbon::now()->month($i)->monthName }}</option>
            @endfor
        </x-select>
        <x-input-error :messages="$errors->get('finish_month')" class="mt-2" />
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="number" :value="__('Proposal Number')" />
            <x-text-input id="number" name="number" type="text" class="mt-1 block w-full" :value="old('number', $budget->number)" required/>
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="payment_type" :value="__('Payment Type')" />
            <x-select id="payment_type" name="payment_type" class="mt-1 block w-full" :collection="App\Enums\PaymentTypeEnum::array()" :optionSelected="$budget->payment_type" required />
            <x-input-error :messages="$errors->get('payment_type')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="value" :value="__('Budget Value')" />
            <x-text-input id="value" name="value" type="text" class="mt-1 block w-full" :value="old('value', $budget->value)" required/>
            <x-input-error :messages="$errors->get('value')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="commission" :value="__('Commission')" />
            <x-text-input id="comission" name="commission" type="number" max="100" min="1" class="mt-1 block w-full" :value="$budget->commission" required />
            <x-input-error :messages="$errors->get('commission')" class="mt-2" />
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="value" :value="__('Budget Value')" />
            <x-text-input id="value" name="value" type="text" class="mt-1 block w-full" :value="old('value', $budget->value)" required/>
            <x-input-error :messages="$errors->get('value')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="commission" :value="__('Commission')" />
            <x-text-input id="comission" name="commission" type="number" max="100" min="1" class="mt-1 block w-full" :value="$budget->commission" required />
            <x-input-error :messages="$errors->get('commission')" class="mt-2" />
        </div>
    </div>
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