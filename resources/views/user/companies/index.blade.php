<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Indications') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('indications.create') }}">{{__('Create New')}}</x-primary-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white dataTable_container">
                <table class="table__app">
                    <thead>
                        <tr>
                            <th>{{__('Corporate Name')}}</th>
                            <th>{{__('E-mail')}}</th>
                            <th>{{__('Doc. Number')}}</th>
                            <th>{{__('Phone')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(auth()->guard('user')->user()->indications as $company)
                            <tr>
                                <td>{{ $company->corporate_name }}</td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->doc_num }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>