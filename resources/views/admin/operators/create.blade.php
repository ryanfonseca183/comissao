<x-app-layout>
    <x-cards.form back="admin.operators.index" title="Create Operator">
        <x-slot name="description">
            <p class="mt-1 text-sm text-gray-600">
                {{ __('The operator will receive a notification in the informed e-mail to register the access password to the system') }}
            </p>
        </x-slot>
        @include('admin.operators.form', [
            'action' => route('admin.operators.store'),
            'operator' => new App\Models\Operator
        ])
    </x-cards.form>
</x-app-layout>
