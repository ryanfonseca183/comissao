<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="lg:grid grid-cols-3 gap-6">
                    <div class="p-4 sm:p-8 sm:pr-0 border-b lg:border-b-0 lg:border-r border-slate-200">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 flex items-center">
                                <a href="{{ route(request()->query('origin') ?? 'admin.dashboard') }}"><x-icons.arrow-left class="me-2" /></a>
                                {{ __('Indication') }}
                            </h2>
                        </header>
                        <ul class="mt-4">
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2 dark:border-opacity-50">
                                <strong>{{__('Corporate Name')}}</strong> <br/>
                                {{$company->corporate_name}}
                            </li>
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2 dark:border-opacity-50">
                                <strong>{{__('Document')}}</strong> <br/>
                                {{$company->doc_num}}
                            </li>
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2 dark:border-opacity-50">
                                <strong>{{__('Service')}}</strong> <br/>
                                {{$company->service->name}}
                            </li>
                            <li class="w-full border-b border-slate-200 border-opacity-100 py-2 dark:border-opacity-50">
                                <strong>{{__('E-mail')}}</strong> <br/>
                                {{$company->email}}
                            </li>
                            <li class="w-full py-2">
                                <strong>{{__('Phone')}}</strong> <br/>
                                {{$company->phone}}
                            </li>
                        </ul>
                    </div>
                    <div class="col-span-2">
                        <div class="p-4 sm:p-8 max-w-xl">
                            @yield('page-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>