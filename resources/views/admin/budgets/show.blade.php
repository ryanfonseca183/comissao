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
    @include('admin.budgets.form', [
        'action' => "#",
        'budget' => $company->budget
    ])
@endsection

@push('js')
    <script>
        $("input, select, textarea", $("form")).prop("disabled", true);
        $("button", $("form")).remove();
    </script>
@endpush