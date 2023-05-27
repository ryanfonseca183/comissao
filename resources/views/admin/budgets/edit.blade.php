@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Edit Budget') }}
        </h2>
        <span class="text-xs italic">
            Criado em {{ $company->budget->created_at->format('d/m/Y') }}
            às {{$company->budget->created_at->format('H:i')}}
        </span>
    </header>
    @include('admin.budgets.form', [
        'action' => route('admin.indications.budget.update', $company),
        'budget' => $company->budget,
        'method' => 'PUT',
    ])
@endsection