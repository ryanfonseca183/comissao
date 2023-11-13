<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off" id="indication">
    @csrf
    @method($method ?? 'POST')
    @if(request()->routeIs('admin.*'))
        <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
        <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
        <script src="{{asset('plugins/select2/select2-pt-BR.js')}}"></script>
        <div>
            <x-input-label for="partner" :value="__('Partner')" />
            <x-select id="partner" name="user_id" required/>
            <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
        </div>
    @endif
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
    <div id="measuring_area_control">
        <x-input-label for="measuring_area" :value="__('Measuring Area')" />
        <x-text-input id="measuring_area" name="measuring_area" type="text" class="mt-1 block w-full decimal" :value="old('measuring_area', $company->measuring_area)" required/>
        <x-input-error :messages="$errors->get('measuring_area')" class="mt-2" />
    </div>
    <div id="employees_number_control">
        <x-input-label for="employees_number" :value="__('Employees Number')" />
        <x-text-input id="employees_number" name="employees_number" type="text" class="mt-1 block w-full integer" :value="old('employees_number', $company->employees_number)" required/>
        <x-input-error :messages="$errors->get('employees_number')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="note" :value="(__('Note') . ' (Máx. 1000)')" />
        <x-textarea id="note" name="note" class="mt-1 block w-full" rows="5" maxlength="1000">{{old('note', $company->note)}}</x-textarea>
        <x-input-error :messages="$errors->get('note')" class="mt-2" />
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>

<script>
    $(function(){
        @if(request()->routeIs('admin.*'))
            $('#partner').select2({
                placeholder: 'Selecione um parceiro',
                minimumInputLength: 3,
                language: "pt-BR",
                width: "100%",
                ajax: {
                    url: "{{route('admin.users.autocomplete')}}",
                    dataType: 'json',
                    delay: 500,
                    processResults: function (data) {
                            return {
                            results: Object.values(data)
                        }
                    },
                    data: function (params) {
                        return {search: params.term}
                    }
                } 
            });
            @if($company->id)
                var newOption = new Option("{{$company->user?->name}}", "{{$company->user->id}}", true, true);
                $('#partner').append(newOption).trigger('change');
            @endif
        @endif
        let val = $("#doc_type").val();
        $("#service_id").change(function(){
            const service = this.value
            toggleControl($("#measuring_area_control"), 
                service && "{{config('app.services_with_measuring_area')}}".includes(service)
            )
            toggleControl($("#employees_number_control"), 
                service && "{{config('app.services_with_employees_number')}}".includes(service)
            )
        }).trigger('change');

        function toggleControl(control, bool) {
            control.toggleClass('hidden', !bool).find('input').prop('disabled', !bool)
        }
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