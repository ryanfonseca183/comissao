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
                                <th>{{__('Corporate Name')}}</th>
                                <th>{{__('Document')}}</th>
                                <th>{{__('Service')}}</th>
                                <th>{{__('E-mail')}}</th>
                                <th>{{__('Phone')}}</th>
                                <th>{{__('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indications as $indication)
                                <tr>
                                    <td>{{ $indication->corporate_name }}</td>
                                    <td>{{ $indication->doc_num }}</td>
                                    <td>{{ $indication->service->name }}</td>
                                    <td>{{ $indication->email }}</td>
                                    <td>{{ $indication->phone }}</td>
                                    <td>
                                       <a href="{{route('admin.indications.budgets.create', $indication)}}" class="me-2">{{__('Create')}}</a>
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
