<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Partners') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('admin.users.create') }}">{{__('Create New')}}</x-primary-button>
        </div>
        
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dataTable_container">
                <div class="p-6 text-gray-900">
                    <table class="table__app">
                        <thead>
                            <tr>
                                <th>{{__('Name')}}</th>
                                <th>{{__('E-mail')}}</th>
                                <th>{{__('Doc. Number')}}</th>
                                <th>{{__('Phone')}}</th>
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
                    url: '{{ route("admin.users.datatable") }}',
                },
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'doc_num', name: 'doc_num' },
                    { data: 'phone', name: 'phone' },
                    { data: 'actions' },
                ],
            }
        </script>
    @endpush
</x-app-layout>

