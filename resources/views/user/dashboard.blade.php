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
                                <th class="none">{{__('Document')}}</th>
                                <th class="none">{{__('E-mail')}}</th>
                                <th class="none">{{__('Phone')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('Installment')}}</th>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Value')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indications as $indication)
                                @php $value = (float) $indication->budget->value * ($indication->budget->commission / 100); @endphp
                                @foreach($indication->payments as $payment)
                                    @php $pending = $payment->payment_date->greaterThan(now()); @endphp
                                    <tr>
                                        <td>{{ $indication->corporate_name }}</td>
                                        <td>{{ $indication->doc_num }}</td>
                                        <td>{{ $indication->email }}</td>
                                        <td>{{ $indication->phone }}</td>
                                        <td>{{ $indication->service->name }}</td>
                                        <td>
                                            @if($indication->budget->payment_term > 1)
                                                {{ $payment->installment }}/{{$indication->budget->payment_term}}
                                            @else
                                                única
                                            @endif
                                        </td>
                                        <td @if(! $pending) class="text-red-600" @endif>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                        <td @if($pending) data-order="{{$value}}" @endif>R$ {{ number_format($value, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(".table__app").on('draw.dt', function(){
                $('#total').text(money.format(window.dataTable.column(7, {filter:'applied'}).nodes().sum()))
            })
            $("#old_values").change(function(){
                window.location.replace(`{{ route('dashboard') }}?old=${this.checked}`)
            })
        </script>
    @endpush
</x-app-layout>

