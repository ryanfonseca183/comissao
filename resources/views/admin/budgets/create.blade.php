@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Create Budget') }}
        </h2>
    </header>
    <form
      action="{{route('admin.indications.budget.store', $company)}}"
      autocomplete="off"
      method="post">
        @include('admin.budgets.form', ['budget' => new App\Models\Budget])
        @csrf
    </form>
@endsection