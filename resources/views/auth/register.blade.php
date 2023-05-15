<x-guest-layout>
    @php $doc_type = session()->get('doc_type', 0) @endphp
    <header class="mb-4">
        @if($doc_type == 0)
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Account') }}</h2>
            {{__('Do you want to register as a corporate?')}}
            <a href="{{ route('register.corporate') }}" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">
                {{__('Click here')}}
            </a>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Corporate Account') }}</h2>
            {{__('Do you want to register as a person?')}}
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">
                {{__('Click here')}}
            </a>
        @endif
    </header>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name -->
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
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
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
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Finish') }}
            </x-primary-button>
        </div>
        <hr class="my-6">
        <div class="text-center">
            <h3>Já possui uma conta?</h3>
            <a class="text-indigo-600 hover:text-indigo-800 focus:outline-none" href="{{ route('login', 'user') }}">
                {{ __('Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
