<div>
    <x-input-label for="name" :value="__($doc_type == 0 ? 'Name' : 'Corporate Name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="doc_num" :value="__($doc_type == 0 ? 'CPF' : 'CNPJ')" />
        <x-text-input id="doc_num" class="{{ $doc_type == 0 ? 'cpf' : 'cnpj' }} block mt-1 w-full" type="text" name="doc_num" :value="old('doc_num')" required />
        <x-input-error :messages="$errors->get('doc_num')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="phone" :value="__('Phone')" />
        <x-text-input id="phone" class="phone block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
</div>
<div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>
<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="password" :value="__('Password')" />
        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>
</div>