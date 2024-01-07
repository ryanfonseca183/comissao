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
                    <header class="mb-4">
                        <h2 class="text-lg font-medium text-gray-900 flex items-center justify-between">
                            {{ __('Commissions') }}
                            <div>
                                <small>Total a receber: </small>
                                <strong id="total"></strong>
                            </div>
                        </h2>
                    </header>
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('Installments')}}</th>
                                <th>{{__('Last Installment Date')}}</th>
                                <th>{{__('Total')}}</th>
                                <th>{{__('Pending')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indications as $indication)
                                <tr>
                                    <td>{{$indication->corporate_name}}</td>
                                    <td>{{$indication->service->name}}</td>
                                    <td>{{$indication->payments->count()}}</td>
                                    <td>{{$indication->payments->max('expiration_date')->format('d/m/Y')}} </td>
                                    @php 
                                        $total = $indication->payments->sum('value');
                                        $paid = $indication->payments->where('paid', 1)->sum('value');
                                        $pending = $total - $paid;
                                    @endphp
                                    <td data-order="{{$total}}">R$ {{ number_format($total, 2, ',', '.') }}</td>
                                    <td data-order="{{$pending}}">R$ {{ number_format($pending, 2, ',', '.') }}</td>
                                    <td>
                                        <x-buttons.show :route="route('indications.show', $indication)" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            const dataTableConfigs = {
                order: [[5, 'desc']]
            }
            $(function(){
                $(".table__app").on('draw.dt', function(){
                    $('#total').text(money.format(window.dataTable.column(5).nodes().sum()))
                })
            })
        </script>
    @endpush
</x-app-layout>

