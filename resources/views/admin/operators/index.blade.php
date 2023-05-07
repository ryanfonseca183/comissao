<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Operators') }}
            </h2>
            <x-primary-button tag="a" href="{{ route('admin.operators.create') }}">Criar novo</x-primary-button>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white dataTable_container">
                <table class="table__app">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Models\Operator::where('isAdmin', 0)->get() as $operator)
                            <tr>
                                <td>{{ $operator->name }}</td>
                                <td>{{ $operator->email }}</td>
                                <td>{{ $operator->phone }}</td>
                                <td>{{ $operator->status ? 'Ativo' : 'Inativo' }}</td>
                                <td>
                                    <a href="{{route('admin.operators.edit', $operator)}}" class="me-2">Editar</a>
                                    <a href="#" class="text-red-500">Excluir</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>