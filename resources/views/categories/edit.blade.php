<x-app-layout>

    @livewire('booking-category-edit', ['category' => $category], key(key(now()) . '-' . Str::random()))

</x-app-layout>
