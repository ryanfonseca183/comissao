<x-app-layout>
    <x-cards.form back="indications.index" title="Edit Indication">
        @include('user.companies.form', [
            'action' => route('indications.update', ['indication' => $company->id]),
            'company' => $company,
            'method' => 'PUT'
        ])
    </x-cards.form>
</x-app-layout>