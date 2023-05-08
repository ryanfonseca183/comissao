<x-app-layout>
    <x-cards.form back="admin.operators.index" title="Edit Operator">
        <x-slot name="description">
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Fill in the fields you would like to edit and click save') }}
            </p>
        </x-slot>
        @include('admin.operators.form', [
            'action' => route('admin.operators.update', $operator),
            'operator' => $operator,
            'method' => 'PUT'
        ])
    </x-cards.form>
</x-app-layout>
