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
                            <div class="inline-flex items-center">
                                <span class="me-4">{{ __('Commissions') }}</span>
                                <x-switch label="Mostrar valores passados" id="old_values" :checked="request()->query('old', false) == 'true'"/>
                            </div>
                            <div>
                                <small>Total à receber: </small>
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
                                <th>{{__('Comission')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indications as $indication)
                                <tr>
                                    <td>{{ $indication->corporate_name }}</td>
                                    <td>{{ $indication->service->name }}</td>
                                    <td>
                                        @if($indication->budget->payment_term > 1)
                                            {{$indication->budget->payment_term}}
                                        @else
                                            única
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>{{ $indication->comission }}</td>
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
                columnDefs: [
                    {targets: 4, orderable: true}
                ]
            }
            $(function(){
                $(".table__app").on('draw.dt', function(){
                    $('#total').text(money.format(window.dataTable.column(4, {filter:'applied'}).nodes().sum()))
                })
                $("#old_values").change(function(){
                    window.location.replace(`{{ route('dashboard') }}?old=${this.checked}`)
                })
            })
        </script>
    @endpush
</x-app-layout>

