<x-app-layout>
    <x-cards.form back="admin.users.index" title="Create Partner">
        <x-slot name="description">
            <p class="mt-1 text-sm text-gray-600">
                {{ __('The partner will receive a notification in the informed e-mail to register the access password to the system') }}
            </p>
        </x-slot>
        @include('admin.users.form', [
            'action' => route('admin.users.store'),
            'user' => new App\Models\User
        ])
    </x-cards.form>
</x-app-layout>
