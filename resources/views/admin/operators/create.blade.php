<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Operators') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <a href="{{ route('admin.operators.index') }}"><x-icons.arrow-left class="me-2" /></a>
                                {{ __('Create Operator') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('O Operador irá receber um e-mail para cadastrar a senha de acesso ao sistema') }}
                            </p>
                        </header>
                        @include('admin.operators.form', ['action' => route('admin.operators.store'), 'operator' => new App\Models\Operator])
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
