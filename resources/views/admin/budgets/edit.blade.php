@extends('admin.budgets.layout')

@section('page-content')
    <header>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-900 flex items-center">
                    {{ __('Edit Budget') }}
                    @if($company->statusEqualTo('FECHADO'))
                        <x-badge :label="App\Enums\IndicationStatusEnum::label($company->status)" context="bg-green-100 text-green-800 ms-2" />
                    @endif
                </h2>
                <span class="text-xs italic">
                    Criado em {{ $company->budget->created_at->format('d/m/Y') }}
                    às {{$company->budget->created_at->format('H:i')}}
                </span>
            </div>
            @if($company->statusEqualTo('FECHADO'))
                <div x-data="{openModal: false}">
                    <x-modals.base icon="icons.alert" away="openModal = false" x-show="openModal">
                        Tem certeza que deseja rescindir esse contrato?
                        Todas as parcelas de comissão pendentes serão deletadas.
                        A operação não é reversível.
                        <x-slot name="actions">
                            <form method="POST" action="{{ route('admin.indications.budget.revoke', $company) }}">
                                @csrf
                                <button
                                class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                type="submit">
                                    Rescindir
                                </button>
                            </form>
                            <button
                              class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                              @click="openModal = false"
                              type="button">
                                Cancelar
                            </button>
                        </x-slot>
                    </x-modals.base>
                    <x-danger-button
                    type="button"
                    @click="openModal = true;">
                        {{ __('Rescindir Contrato') }}
                    </x-danger-button>
                </div>
            @endif
        </div>
        
    </header>
    @if($company->statusDiffFrom('FECHADO'))
        @include('admin.budgets.close', ['budget' => $company->budget])
    @endif
    <form
      action="{{ route('admin.indications.budget.update', $company) }}"
      autocomplete="off"
      method="post">
        @include('admin.budgets.form', ['budget' => $company->budget])
        @method('PUT')
        @csrf
    </form>
    @if($company->statusEqualTo('FECHADO') && $payments->count() > 0)
        <h2 class="text-lg font-medium text-gray-900 mb-3">{{ __('Commissions') }}</h2>
        @include('admin.budgets.payments', compact('company', 'payments'))
    @endif
@endsection