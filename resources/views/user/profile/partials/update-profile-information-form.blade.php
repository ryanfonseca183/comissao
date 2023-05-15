<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__($user->doc_type == 0 ? 'Name' : 'Corporate Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="doc_num" :value="__($user->doc_type == 0 ? 'CPF' : 'CNPJ')" />
                <x-text-input id="doc_num" name="doc_num" type="text" class="{{$user->doc_type == 0 ? 'cpf' : 'cnpj'}} mt-1 block w-full" :value="old('doc_num', $user->doc_num)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('doc_num')" />
            </div>
        </div>
        <div class="grid sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full phone" :value="old('phone', $user->phone)" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
</section>
