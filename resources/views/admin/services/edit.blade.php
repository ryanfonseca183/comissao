<x-app-layout>
    <x-cards.form back="admin.services.index" title="Edit Service">
        @include('admin.services.form', [
            'action' => route('admin.services.update', $service),
            'service' => $service,
            'method' => 'PUT'
        ])
    </x-cards.form>
</x-app-layout>
