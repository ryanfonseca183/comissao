@foreach([
    'operators' => ['label' => 'Operadores', 'route' => 'admin.operators.index', 'restricted' => true],
] as $resource => $menu)
    @if($menu['restricted']) @continue @endif
    <x-nav-link :href="route($menu['route'])" :active='request()->routeIs("admin.$resource.*")'>
        {{ __($menu['label']) }}
    </x-nav-link>
@endforeach