<x-guest-layout>
    @php $doc_type = session()->get('doc_type', 0) @endphp
    <header class="mb-4">
        @if($doc_type == 0)
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Account') }}</h2>
            {{__('Do you want to register as a corporate?')}}
            <a href="{{ route('register.corporate') }}" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">
                {{__('Click here')}}
            </a>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Corporate Account') }}</h2>
            {{__('Do you want to register as a person?')}}
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 focus:outline-none">
                {{__('Click here')}}
            </a>
        @endif
    </header>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        @include('auth.register.form', compact('doc_type'))
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Finish') }}
            </x-primary-button>
        </div>
        <hr class="my-6">
        <div class="text-center">
            <h3>Já possui uma conta?</h3>
            <a class="text-indigo-600 hover:text-indigo-800 focus:outline-none" href="{{ route('login', 'user') }}">
                {{ __('Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>