<form method="post" action="{{ $action }}" class="mt-6 space-y-6" autocomplete="off">
    @csrf
    @method($method ?? 'POST')
    <div>
        <x-input-label for="name" :value="__('Name')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $operator->name)" required/>
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email', $operator->email)" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full phone" :value="old('phone', $operator->phone)" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="status" :value="__('Status')" />
            <x-select name="status" class="mt-1 block w-full" :collection="App\Enums\StatusEnum::array()" :optionSelected="$operator->status ?? 1" required />
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
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