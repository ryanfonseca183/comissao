<x-app-layout>
    <x-cards.form back="admin.users.index" title="Edit Partner">
        @include('admin.users.form', [
            'action' => route('admin.users.update', $user),
            'method' => 'PUT',
            'user' => $user
        ])
    </x-cards.form>
</x-app-layout>
