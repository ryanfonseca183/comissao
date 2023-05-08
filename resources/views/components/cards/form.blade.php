@props(['back' => '', 'title'])
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 flex items-center">
                            @if($back)
                                <a href="{{ route($back) }}"><x-icons.arrow-left class="me-2" /></a>
                            @endif
                            {{ __($title) }}
                        </h2>
                        {{$description ?? ''}}
                    </header>
                    {{$slot}}
                </section>
            </div>
        </div>
    </div>
</div>