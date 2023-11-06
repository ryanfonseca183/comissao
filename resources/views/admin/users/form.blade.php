<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off">
    @csrf
    @method($method ?? 'POST')
    <div>
        <x-input-label for="name" :value="__('Name / Corporate Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required/>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="doc_type" :value="__('Doc. Type')" />
            <x-select id="doc_type" name="doc_type" :collection="[1 => 'CPF', 2 => 'CNPJ']" class="mt-1 block w-full" :optionSelected="$user->doc_type ?? 2"  required/>
            <x-input-error :messages="$errors->get('doc_type')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="doc_num" :value="__('Doc. Number')" />
            <x-text-input id="doc_num" name="doc_num" type="text" class="mt-1 block w-full" :value="old('doc_num', $user->doc_num)" required/>
            <x-input-error :messages="$errors->get('doc_num')" class="mt-2" />
        </div>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full phone" :value="old('phone', $user->phone)" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
    </div>
    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
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