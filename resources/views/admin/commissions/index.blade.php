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
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('Installment')}}</th>
                                <th>{{__('Value')}}</th>
                                <th>{{__('Expiration Date')}}</th>
                                <th>{{__('Pago')}}</th>
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
                ajax: '{{ route("admin.payments.datatable") }}',
                columnDefs: [
                    {targets: 3, orderable: true}
                ],
                order: [[ 4, 'asc' ]],
                columns: [
                    { data: 'corporate_name', name: 'companies.corporate_name' },
                    { data: 'name', name: 'services.name' },
                    { data: 'installment', name: 'installment' },
                    { data: 'value', name: 'value' },
                    { data: 'payment_date', name: 'payment_date' },
                    { data: 'paid', name: 'paid' },
                ],
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

