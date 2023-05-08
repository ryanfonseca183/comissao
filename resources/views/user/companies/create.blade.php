<x-app-layout>
    <x-cards.form back="indications.index" title="Create Indication">
        @include('user.companies.form', [
            'action' => route('indications.store'),
            'company' => new App\Models\Company
        ])
    </x-cards.form>
</x-app-layout>
