<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Budgets') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dataTable_container">
                <div class="p-6 text-gray-900">
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Contract End Date')}}</th>
                                <th>{{__('Doc. Number')}}</th>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Partner')}}</th>
                                <th>{{__('Proposal Number')}}</th>
                                <th>{{__('Budget Value')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td @if($budget->expiredOrCloseToExpire) class="text-red-400" @endif>
                                        {{ $budget->expiration_date->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $budget->company->doc_num }}</td>
                                    <td>{{ $budget->company->corporate_name }}</td>
                                    <td>{{ $budget->company->user->name }}</td>
                                    <td>{{ $budget->number }}</td>
                                    <td>R$ {{ number_format($budget->totalValue, 2, ',', '.') }}</td>
                                    <td>{{ App\Enums\IndicationStatusEnum::label($budget->company->status) }}<td>
                                        <a href="{{ route('admin.indications.budget.edit', [
                                            'company' => $budget->company_id,
                                            'origin' => request()->route()->getName()
                                        ]) }}">Visualizar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>