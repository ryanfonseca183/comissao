@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <h2 class="text-lg font-medium text-gray-900 flex items-center">
            {{ __('Budget') }}
            @if($company->statusIn(['FECHADO', 'RECUSADO']))
                <x-badge
                    :label="App\Enums\IndicationStatusEnum::label($company->status)"
                    :context="($company->statusEqualTo('FECHADO') ? 'bg-green-100 text-green-800 ms-2' : 'bg-red-100 text-red-800 ms-2')" />
            @endif
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
@endsection

@push('js')
    <script>
        $("input, select, textarea", $("#budget")).prop("disabled", true);
    </script>
@endpush