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
                            <th>{{__('Doc. Number')}}</th>
                            <th>{{__('Service')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($indications as $company)
                            <tr>
                                <td>{{ $company->corporate_name }}</td>
                                <td>{{ $company->doc_num }}</td>
                                <td>{{ $company->service->name }}</td>
                                <td>{{ App\Enums\IndicationStatusEnum::label($company->status) }}</td>
                                <td>
                                    @if($company->statusEqualTo('PENDENTE'))
                                        <a href="{{ route('indications.edit', $company) }}" class="me-2">{{__('Edit')}}</a>
                                        <form action="{{ route('indications.destroy', $company) }}" class="inline-block" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="text-red-500">{{__('Delete')}}</button>
                                        </form>
                                    @else
                                        <a href="{{ route('indications.show', $company) }}" class="me-2">{{__('Show')}}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>