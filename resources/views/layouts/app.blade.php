<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{asset('plugins/datatables.min.css')}}" rel="stylesheet"/>
        <script src="{{asset('plugins/jquery.min.js')}}"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="loader grid place-items-center fixed top-0 left-0 h-screen w-screen bg-white z-50">
            <div role="status">
                <x-icons.loader/>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="min-h-screen bg-gray-100 flex flex-col">
            @php $guard = request()->routeIs('admin.*') ? 'admin' : 'user'; @endphp
            <x-navigation :$guard>
                <x-slot name="large">
                    <x-dynamic-component :component="($guard.'.menu')" name="nav-link"/>
                </x-slot>
                <x-slot name="small">
                    <x-dynamic-component :component="($guard.'.menu')" name="responsive-nav-link"/>
                </x-slot>
            </x-navigation>
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            <footer class="shadow mt-auto bg-white ">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <div class="flex flex-col sm:flex-row pb-5 sm:pb-0 gap-5 sm:gap-0">
                        <div class="pe-2 me-2 flex items-center sm:border-e">
                            <img src="{{ asset('images/logo.png') }}"
                                 alt="Organizar Engenharia"
                                 class="h-20 w-auto inline-block">
                        </div>
                        <div class="flex-1 border-t sm:border-t-0 pt-4 sm:pt-0 sm:px-4">
                            <p class="mb-3">
                                Empresa especializada nas áreas de segurança do trabalho,
                                meio ambiente e sistemas de prevenção contra incêndio e pânico.
                                Confira também nossa loja para ter acesso a EPIs e materiais contra incêndio.
                                 <br/>
                                <a href="http://www.grupoorganizar.com.br/" target="_blank">http://www.grupoorganizar.com.br/</a>
                            </p>
                            <address>
                                R. Francisco Soraggi, 15 - Santa Luzia<br/>
                                Formiga/MG
                            </address>
                        </div>
                        <ul class="flex gap-3 items-center">
                            <li><a href="https://www.facebook.com/organizareng" target="_blank"><x-icons.facebook width="30" height="30" /></a></li>
                            <li><a href="https://www.instagram.com/organizarengenharia/" target="_blank"><x-icons.instagram width="35" height="35"/></a></li>
                            <li><a href="https://api.whatsapp.com/send?phone=+5537999881070&text=Ol%C3%A1,%20gostaria%20de%20solicitar%20uma%20proposta%20comercial." target="_blank"><x-icons.whatsapp width="30" height="30"/></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
        @stack('js')
        <script src="{{asset('plugins/datatables.min.js')}}"></script>
        <script src="{{asset('plugins/datatable-defaults.js')}}"></script>
        <script src="{{asset('plugins/jquery.mask.min.js')}}"></script>
        <script src="{{asset('js/masks.js')}}"></script>
        <script src="{{asset('js/functions.js')}}"></script>
        <script>
            $(function(){
                setTimeout(function(){
                    $('.loader').hide();
                }, 500)
                @foreach(['success', 'error', 'info', 'warning'] as $type)
                    @if(Session::has('f-'.$type))
                        Toastr.{{$type}}(`{{ session('f-'.$type) }}`);
                    @endif
                @endforeach
            })
        </script>
    </body>
</html>
