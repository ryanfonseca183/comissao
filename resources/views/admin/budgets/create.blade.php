@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Create Budget') }}
        </h2>
    </header>
    @include('admin.budgets.form', [
        'action' => route('admin.indications.budget.store', $company),
        'budget' => new App\Models\Budget
    ])
@endsection