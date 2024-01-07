@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Budget') }}
            <x-badge :label="App\Enums\IndicationStatusEnum::label($company->status)" context="bg-red-100 text-red-800 ms-2" />
        </h2>
        <span class="text-xs italic">
            Criado em {{ $company->budget->created_at->format('d/m/Y') }}
            às {{$company->budget->created_at->format('H:i')}}
        </span>
    </header>
    @include('admin.budgets.form', [
        'action' => "#",
        'budget' => $company->budget
    ])
    <h2 class="text-lg font-medium text-gray-900 mb-3">{{ __('Commissions') }}</h2>
    @include('admin.budgets.payments', compact('company'))
@endsection


@push('js')
    <script>
        $("input:not([type='hidden']), select, textarea", $("#budget")).prop("disabled", true);
    </script>
@endpush