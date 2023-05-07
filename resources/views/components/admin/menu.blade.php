@foreach([
    'operators' => ['label' => 'Operadores', 'route' => 'admin.operators.index'],
] as $resource => $menu)
    <x-nav-link :href="route($menu['route'])" :active='request()->routeIs("admin.$resource.*")'>
        {{ __($menu['label']) }}
    </x-nav-link>
@endforeach