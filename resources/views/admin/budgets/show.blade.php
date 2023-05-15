@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Budget') }}
            <span class="ms-2 text-xs italic">
                Criado em {{ $company->budget->created_at->format('d/m/Y') }}
                às {{$company->budget->created_at->format('H:i')}}
            </span>
        </h2>
        <span class="text-sm">
            O orçamento poderá ser editado em até 1
            hora a partir da data de criação
        </span>
    </header>
    <div id="budget_form">
        @include('admin.budgets.form', [
            'action' => "#",
            'budget' => $company->budget
        ])
    </div>
@endsection

@push('js')
    <script>
        $("input, select, textarea", $("#budget_form")).prop("disabled", true);
        $("button", $("#budget_form")).remove();
    </script>
@endpush