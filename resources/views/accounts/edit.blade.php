<x-app-layout>

    @livewire('booking-account-edit', ['account' => $account], key(key(now()) . '-' . Str::random()))

</x-app-layout>
