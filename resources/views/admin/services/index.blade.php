<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Services') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('admin.services.create') }}">{{__('Create New')}}</x-primary-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white dataTable_container">
                <table class="table__app">
                    <thead>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\Service::all() as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ __($service->status ? 'Active' : 'Inactive') }}</td>
                                <td>
                                    <div class="flex items-center">
                                        <x-buttons.edit :route="route('admin.services.edit', $service)" :icon="true" />
                                        <x-buttons.delete :route="route('admin.services.destroy', $service)" :icon="true"/>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>