<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Indications') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('admin.indications.create') }}">{{__('Create New')}}</x-primary-button>
        </div>
        
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dataTable_container">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-6 gap-4 mb-5">
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select id="status" class="mt-1 block w-full filter" :collection="App\Enums\IndicationStatusEnum::array()" :optionSelected="0" placeholder="Todos" />
                        </div>
                    </div>
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Doc. Number')}}</th>
                                <th>{{__('Partner')}}</th>
                                <th>{{__('Service')}}</th>
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
                    url: '{{ route("admin.indications.datatable") }}',
                    data: function(d) {
                        d.status = $("#status").val();
                    }
                },
                columns: [
                    { data: 'corporate_name', name: 'corporate_name' },
                    { data: 'doc_num', name: 'doc_num' },
                    { data: 'username', name: 'users.name' },
                    { data: 'service', name: 'services.name' },
                    { data: 'status', name: 'status' },
                    { data: 'actions' },
                ],
            }
            $(function(){
                $(".filter").on('change', function(){
                    window.dataTable.ajax.reload();
                })
            })
        </script>
    @endpush
</x-app-layout>

