<x-app-layout>
    <x-cards.form back="admin.services.index" title="Create Service">
        @include('admin.services.form', [
            'action' => route('admin.services.store'),
            'service' => new App\Models\Service
        ])
    </x-cards.form>
</x-app-layout>
