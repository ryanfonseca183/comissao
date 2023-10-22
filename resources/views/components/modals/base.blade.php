@props(['title' => 'Atenção!', 'icon' => '', 'away' => ''])

<div {{$attributes}} class="fixed inset-0 z-10 w-screen overflow-y-auto bg-gray-700/50" x-transition>
    <div class="flex min-h-full items-end justify-center p-4 text-center items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg" @if($away) @click.away="{{$away}}" @endif>
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    @if($icon)
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <x-dynamic-component :component="$icon" />
                        </div>
                    @endif
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">{{$title}}</h3>
                        {{$slot}}
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                {{$actions}}
            </div>
        </div>
    </div>
</div>
