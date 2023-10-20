@props(['name' => 'nav-link'])

@foreach([
    'operators' => [
        'label' => 'Operadores',
        'route' => 'admin.operators.index',
        'visible' => auth()->guard('admin')->user()->isAdmin,
    ],
    'services' => [
        'label' => 'Serviços',
        'route' => 'admin.services.index',
        'visible' => auth()->guard('admin')->user()->isAdmin,
    ],
    'budgets' => [
        'label' => 'Orçamentos',
        'route' => 'admin.budgets.index',
        'visible' => true,
    ],
    'commissions' => [
        'label' => 'Comissões',
        'route' => 'admin.commissions.index',
        'visible' => true,
    ],
] as $resource => $menu)
    @if(! $menu['visible']) @continue @endif
    <x-dynamic-component :component="$name" :href="route($menu['route'])" :active='request()->routeIs("admin.$resource.*")'>
        {{ __($menu['label']) }}
    </x-dynamic-component>
@endforeach