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
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Doc. Number')}}</th>
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
                },
                columns: [
                    { data: 'corporate_name', name: 'corporate_name' },
                    { data: 'doc_num', name: 'doc_num' },
                    { data: 'name', name: 'services.name' },
                    { data: 'status', name: 'status' },
                    { data: 'actions' },
                ],
            }
        </script>
    @endpush
</x-app-layout>

