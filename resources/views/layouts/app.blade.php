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
        <div class="min-h-screen bg-gray-100">
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
