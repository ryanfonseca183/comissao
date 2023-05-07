<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Services') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('admin.services.create') }}">Criar novo</x-primary-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white dataTable_container">
                <table class="table__app">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\Service::all() as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->status ? 'Ativo' : 'Inativo' }}</td>
                                <td>
                                    <a href="{{route('admin.service.edit', $service)}}" class="me-2">Editar</a>
                                    <form action="{{ route('admin.service.destroy', $service) }}" class="inline-block" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="text-red-500">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>