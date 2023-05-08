@props(['name' => 'nav-link'])

@foreach([
    'indications' => [
        'label' => 'Indicações',
        'route' => 'indications.index',
        'visible' => true,
    ]
] as $resource => $menu)
    @if(! $menu['visible']) @continue @endif
    <x-dynamic-component :component="$name" :href="route($menu['route'])" :active='request()->routeIs("$resource.*")'>
        {{ __($menu['label']) }}
    </x-dynamic-component>
@endforeach