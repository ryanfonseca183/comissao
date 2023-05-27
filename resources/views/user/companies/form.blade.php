<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off" id="indication">
    @csrf
    @method($method ?? 'POST')
    <div>
        <x-input-label for="corporate_name" :value="__('Corporate Name')" />
        <x-text-input id="corporate_name" name="corporate_name" type="text" class="mt-1 block w-full" :value="old('corporate_name', $company->corporate_name)" required/>
        <x-input-error :messages="$errors->get('corporate_name')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="phone mt-1 block w-full" :value="old('phone', $company->phone)" required/>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div class="sm:col-span-2">
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $company->email)" required/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="doc_type" :value="__('Doc. Type')" />
            <x-select id="doc_type" name="doc_type" :collection="[1 => 'CPF', 2 => 'CNPJ']" class="mt-1 block w-full" :optionSelected="$company->doc_type ?? 2"  required/>
            <x-input-error :messages="$errors->get('doc_type')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="doc_num" :value="__('Doc. Number')" />
            <x-text-input id="doc_num" name="doc_num" type="text" class="mt-1 block w-full" :value="old('doc_num', $company->doc_num)" required/>
            <x-input-error :messages="$errors->get('doc_num')" class="mt-2" />
        </div>
    </div>
    <div>
        @php $services = App\Models\Service::active()->get(); @endphp
        <x-input-label for="service_id" :value="__('Service')" />
        <x-select id="service_id" name="service_id" :collection="$services" class="mt-1 block w-full" optionLabel="name" optionValue="id" :optionSelected="$company->service_id"  required/>
        <x-input-error :messages="$errors->get('service')" class="mt-2" />
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

<script>
    $(function(){
        let val = $("#doc_type").val();
        $("#doc_type").change(function(){
            if(val != this.value)
                $("#doc_num").val('');
            if(this.value == 1)
                $("#doc_num").mask('000.000.000-00', {reverse: true})
            else
                $("#doc_num").mask('00.000.000/0000-00', {reverse: true})
        }).trigger('change');
    })
</script>