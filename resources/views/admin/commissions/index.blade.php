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
                        </h2>
                    </header>
                    <div class="grid grid-cols-6 gap-4 mb-5">
                        <div>
                            <x-input-label for="day" :value="__('Day')" />
                            <x-text-input id="day" type="text" class="mt-1 block hundred w-full filter" />
                        </div>
                        <div>
                            <x-input-label for="month" :value="__('Month')" />
                            <x-select id="month" type="text" class="mt-1 block w-full filter" >
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{strlen($i) == 1 ? "0" . $i : $i}}" @if($i == now()->month) selected @endif>
                                        {{ now()->setMonth($i)->locale('pt-br')->monthName }}
                                    </option>
                                @endfor
                            </x-select>
                        </div>
                        <div>
                            <x-input-label for="year" :value="__('Year')" />
                            <x-text-input id="year" type="text" class="mt-1 block thousand w-full filter" value="{{now()->year}}" />
                        </div>
                    </div>
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('Installment')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Expiration Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            const dataTableConfigs = {
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.payments.datatable") }}',
                    data: function(d) {
                        d.year = $("#year").val();
                        d.month = $("#month").val();
                        d.day = $("#day").val();
                    }
                },
                order: [[ 4, 'asc' ]],
                columns: [
                    { data: 'corporate_name', name: 'companies.corporate_name' },
                    { data: 'name', name: 'services.name' },
                    { data: 'installment', name: 'installment' },
                    { data: 'value', name: 'value' },
                    { data: 'expiration_date', name: 'expiration_date' },
                    { data: 'paid', name: 'paid' },
                    { data: 'actions' },
                ],
            }
            $(function(){
                $(".table__app").on('draw.dt', function(){
                    $('#total').text(money.format(window.dataTable.column(4, {filter:'applied'}).nodes().sum()))
                })
                $("#old_values").change(function(){
                    window.location.replace(`{{ route('dashboard') }}?old=${this.checked}`)
                })
                $(".filter").on('change', function(){
                    window.dataTable.ajax.reload();
                })
            })
        </script>
    @endpush
</x-app-layout>

