<x-app-layout>
    <x-cards.form back="indications.index" title="Show Indication">
        <x-slot name="description">
            <span class="text-xs italic">
                Criado em {{ $company->created_at->format('d/m/Y') }}
                às {{$company->created_at->format('H:i')}}
            </span>
        </x-slot>
        @include('user.companies.form', [
            'action' => '#',
            'company' => $company,
        ])
    </x-cards.form>
    @push('js')
        <script>
            $("input, select, textarea", $("#indication")).prop('disabled', true);
            $('button', $('#indication')).remove();
        </script>
    @endpush
</x-app-layout>