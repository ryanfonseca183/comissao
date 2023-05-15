<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dataTable_container">
                <div class="p-6 text-gray-900">
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Creation Date')}}</th>
                                <th>{{__('Finishing Month')}}</th>
                                <th>{{__('Proposal Number')}}</th>
                                <th>{{__('Payment Type')}}</th>
                                <th>{{__('Budget Value')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets as $budget)
                                <tr>
                                    <td>{{ $budget->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ now()->setMonth($budget->finish_month)->monthName }}</td>
                                    <td>{{ $budget->number }}</td>
                                    <td>{{ App\Enums\PaymentTypeEnum::label($budget->payment_type) }}</td>
                                    <td>R$ {{ number_format($budget->value, 2, ',', '.') }}</td>
                                    <td>
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