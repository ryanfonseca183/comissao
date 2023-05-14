<x-app-layout>
    <x-cards.form back="admin.dashboard" title="Create Budget">
        @include('admin.budgets.form', [
            'action' => route('admin.indications.budgets.store', $company),
            'budget' => new App\Models\Budget
        ])
    </x-cards.form>
</x-app-layout>