<x-app-layout>
    <x-cards.form :back="(($context ?? '').'indications.index')" title="Edit Indication">
        <x-slot name="description">
            <span class="text-xs italic">
                Criado em {{ $company->created_at->format('d/m/Y') }}
                às {{$company->created_at->format('H:i')}}
            </span>
        </x-slot>
        @include('user.companies.form', [
            'action' => route(($context ?? '').'indications.update', $company->id),
            'company' => $company,
            'method' => 'PUT'
        ])
    </x-cards.form>
</x-app-layout>