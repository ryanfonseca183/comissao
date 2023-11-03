<x-app-layout>
    <x-cards.form :back="(($context ?? '').'indications.index')" title="Create Indication">
        @include('user.companies.form', [
            'action' => route(($context ?? '').'indications.store'),
            'company' => new App\Models\Company
        ])
    </x-cards.form>
</x-app-layout>
